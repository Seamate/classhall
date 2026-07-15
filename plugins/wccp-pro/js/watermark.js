/**
 * watermark.js
 * Applies a watermark overlay to images on your page.
 * Replicates: repeated diagonal text + bottom-right "PROTECTED IMAGE" stamp.
 *
 * Usage:
 *   // Watermark all <img> tags:
 *   Watermark.applyAll('img');
 *
 *   // Watermark a specific selector:
 *   Watermark.applyAll('.protected-image');
 *
 *   // Watermark one element:
 *   Watermark.apply(document.querySelector('#hero-img'));
 *
 * Options (pass as second argument to applyAll / apply):
 *   text        – repeated watermark text    (default: 'www.mywebsite.com')
 *   color       – text color (rgba)          (default: 'rgba(80,120,160,0.35)')
 *   fontSize    – px size of repeated text   (default: 22)
 *   angle       – rotation in degrees        (default: -35)
 *   stampText   – stamp label                (default: 'PROTECTED IMAGE')
 *   stampColor  – stamp border/text color    (default: '#cc2222')
 *   bottomText  – footer bar text            (default: 'This image is protected')
 */

const Watermark = (() => {

  const DEFAULTS = {
    text:       'www.mywebsite.com',
    color:      'rgba(80,120,160,0.35)',
    fontSize:   18,
    angle:      -35,
    opacity:    0.4,          // global opacity of the watermark text
    spacing:    8,            // multiplier for gap between text repetitions
    stampText:  'PROTECTED IMAGE',
    stampColor: '#cc2222',
    bottomText: 'This image is protected',
  };

  /* ─── helpers ─────────────────────────────────────────── */

  function merge(defaults, overrides) {
    return Object.assign({}, defaults, overrides || {});
  }

  /**
   * Wrap an <img> (or any element) in a positioned container
   * and overlay a <canvas> watermark on top.
   */
  function apply(target, options) {
    const cfg = merge(DEFAULTS, options);

    // Resolve the real element
    const el = typeof target === 'string' ? document.querySelector(target) : target;
    if (!el) return;

    // Avoid double-watermarking
    if (el.dataset.watermarked) return;
    el.dataset.watermarked = '1';

    // ── Replace <img> with <canvas> so the watermark is baked in ──
    const canvas = document.createElement('canvas');

    // Copy all relevant CSS from the img onto the canvas
    const computedStyle = window.getComputedStyle(el);
    canvas.style.cssText = el.style.cssText;
    ['width','height','maxWidth','maxHeight','display','borderRadius',
     'margin','padding','verticalAlign','float'].forEach(prop => {
      if (computedStyle[prop]) canvas.style[prop] = computedStyle[prop];
    });
    canvas.style.cursor = 'default';

    // Disable right-click save on the canvas
    canvas.addEventListener('contextmenu', e => e.preventDefault());

    // Draw once the image has a real size
    function draw() {
      const w = el.naturalWidth  || el.offsetWidth;
      const h = el.naturalHeight || el.offsetHeight;

      // Image not ready yet — bail out, load event will retry
      if (!w || !h) return;

      canvas.width  = w;   // draw at full natural resolution
      canvas.height = h;

      const ctx = canvas.getContext('2d');
      ctx.clearRect(0, 0, w, h);

      // ── 0. Draw the original image into the canvas ──────
      ctx.drawImage(el, 0, 0, w, h);

      // ── 1. Repeated diagonal text ──────────────────────
      ctx.save();
      ctx.font = `bold ${cfg.fontSize}px Arial, sans-serif`;
      ctx.fillStyle = cfg.color;
      ctx.globalAlpha = cfg.opacity;

      const angleRad = (cfg.angle * Math.PI) / 180;
      const textW    = ctx.measureText(cfg.text).width;
      const stepX    = textW  + cfg.fontSize * cfg.spacing;   // horizontal gap
      const stepY    = cfg.fontSize * (cfg.spacing * 0.9);    // vertical gap

      ctx.translate(w / 2, h / 2);
      ctx.rotate(angleRad);

      const diag = Math.sqrt(w * w + h * h);
      const cols = Math.ceil(diag / stepX) + 2;
      const rows = Math.ceil(diag / stepY) + 2;

      for (let r = -rows; r <= rows; r++) {
        for (let c = -cols; c <= cols; c++) {
          ctx.fillText(cfg.text, c * stepX, r * stepY);
        }
      }
      ctx.restore();

      // ── 2. Bottom bar ──────────────────────────────────
      const barH = Math.max(32, h * 0.075);
      ctx.globalAlpha = 1;
      ctx.fillStyle = 'rgba(200,210,220,0.60)';
      ctx.fillRect(0, h - barH, w * 0.60, barH);

      ctx.fillStyle = 'rgba(30,40,55,0.85)';
      ctx.font = `${barH * 0.44}px Arial, sans-serif`;
      ctx.textBaseline = 'middle';
      ctx.fillText(cfg.bottomText, 14, h - barH / 2);

      // ── 3. Red stamp (bottom-right) ────────────────────
      const stampW = Math.min(110, w * 0.22);
      const stampH = stampW;
      const sx = w - stampW - w * 0.02;
      const sy = h - stampH - h * 0.02;

      ctx.save();
      ctx.translate(sx + stampW / 2, sy + stampH / 2);
      ctx.rotate((-12 * Math.PI) / 180);

      // Guard: skip stamp if image too small
      const outerR = stampW / 2;
      const innerR = Math.max(0, outerR - 6);
      if (outerR < 8) { ctx.restore(); return; }

      // Circle
      ctx.beginPath();
      ctx.arc(0, 0, outerR, 0, Math.PI * 2);
      ctx.strokeStyle = cfg.stampColor;
      ctx.lineWidth = 3;
      ctx.globalAlpha = 0.85;
      ctx.stroke();

      // Inner circle (only if radius is positive)
      if (innerR > 0) {
        ctx.beginPath();
        ctx.arc(0, 0, innerR, 0, Math.PI * 2);
        ctx.lineWidth = 1.5;
        ctx.stroke();
      }

      // Stamp text – wrap into two lines
      const words = cfg.stampText.split(' ');
      ctx.fillStyle = cfg.stampColor;
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      const lh = stampW * 0.18;
      ctx.font = `bold ${lh}px Arial, sans-serif`;

      const half = Math.ceil(words.length / 2);
      const line1 = words.slice(0, half).join(' ');
      const line2 = words.slice(half).join(' ');
      ctx.fillText(line1, 0, -lh * 0.6);
      ctx.fillText(line2, 0,  lh * 0.6);

      ctx.restore();
    }

    function doSwap() {
      // Capture display size BEFORE hiding the img
      const displayW = el.offsetWidth  || el.getBoundingClientRect().width  || el.naturalWidth;
      const displayH = el.offsetHeight || el.getBoundingClientRect().height || el.naturalHeight;

      // Set canvas display size first so it's never 0x0
      canvas.style.width  = displayW + 'px';
      canvas.style.height = displayH + 'px';

      // Swap <img> → <canvas> in the DOM, then hide img
      el.parentNode.insertBefore(canvas, el);
      el.style.display = 'none';

      draw();

      // Keep canvas display size in sync on resize
      const ro = new ResizeObserver(() => {
        const rw = el.naturalWidth;
        const rh = el.naturalHeight;
        if (rw && rh) {
          canvas.style.width  = rw + 'px';
          canvas.style.height = rh + 'px';
        }
      });
      ro.observe(canvas);
    }

    if (el.complete && el.naturalWidth) {
      doSwap();
    } else {
      el.addEventListener('load', doSwap);
    }
  }

  /**
   * Apply watermark to every element matching `selector`.
   */
  function applyAll(selector, options) {
    document.querySelectorAll(selector).forEach(el => apply(el, options));
  }

  return { apply, applyAll };

})();


/* ── Auto-init via data attributes ────────────────────────────────────────────
   Add  data-watermark="true"  to any element and it will be watermarked
   automatically when the DOM is ready.
   Optionally add data-watermark-text="Your Site" etc.
──────────────────────────────────────────────────────────────────────────────*/
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-watermark]').forEach(el => {
    const opts = {
      text:      el.dataset.watermarkText      || undefined,
      stampText: el.dataset.watermarkStamp     || undefined,
      bottomText:el.dataset.watermarkBottom    || undefined,
      color:     el.dataset.watermarkColor     || undefined,
    };
    Watermark.apply(el, opts);
  });
});
