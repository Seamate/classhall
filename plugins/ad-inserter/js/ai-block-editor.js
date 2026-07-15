(
function (blocks, element, blockEditor, components) {
  var el                = element.createElement;
  var InspectorControls = blockEditor.InspectorControls;
  var SelectControl     = components.SelectControl;
  var ToggleControl     = components.ToggleControl;
  var RangeControl      = components.RangeControl;
  var PanelBody         = components.PanelBody;

  blocks.registerBlockType ('ad-inserter/block', {
//    supports: {
//      position: {
//        sticky: true
//      },
//    },
    edit: function (props) {
      var aiBlockData = window.aiData.blockData;

      return [
        el (InspectorControls, {key: 'inspector'},
          el (PanelBody, {},
            el (SelectControl, {
                label:    window.aiData.block,
                value:    props.attributes.blockNumber,
                options:  aiBlockData,
                onChange: function (val ) {
                  props.setAttributes ({blockNumber: parseInt (val)});
                },
              }),
            el (ToggleControl, {
                label:   window.aiData.enabled,
                checked: props.attributes.enabled,
                onChange: function (val) {
                  props.setAttributes ({enabled: val});
                },
              }),
            el (ToggleControl, {
                label:   window.aiData.sticky,
                checked: props.attributes.sticky,
                onChange: function (val) {
                  props.setAttributes ({sticky: val});
                },
              }),
            el (RangeControl, {
                label:    window.aiData.stickyHeight,
                value:    props.attributes.stickyHeight,
                onChange: function (val) {
                  props.setAttributes ({stickyHeight: parseInt (val)});
                },
                min: 0,
                max: 3000,
              }),
          )
        ),
        el ('div', {className: 'ai-block-preview'},
          el ('div', {className: 'ai-name'},
            el ('span', {className: 'dashicons dashicons-layout'}
            ),
            el ('span', {className: 'ai-title'},
              window.aiData.adInserterName
            ),
          ),
          el ('div', {className: 'ai-block-info'},
            el ('span', {className: 'dashicons ' + (
              !props.attributes.enabled ? 'dashicons-dismiss red' : (
              !!Number (aiBlockData [props.attributes.blockNumber - 1]['paused']) ? 'dashicons-controls-pause red' : (
              !Number (aiBlockData [props.attributes.blockNumber - 1]['widget']) ? 'dashicons-marker red' : (
              props.attributes.sticky ? 'dashicons-sticky' : (
              !!Number (aiBlockData [props.attributes.blockNumber - 1]['sticky']) ? 'dashicons-sticky blue' : '')))))}
            ),
            el ('a', {className: 'ai-link', href: window.aiData.aiPage + '&start=' + (parseInt ((props.attributes.blockNumber) / 16) * 16 + 1) + '&tab=' + props.attributes.blockNumber + window.aiData.urlParameters, target: '_blank'},
              el ('span', {className: 'ai-block-name', 'data-tooltip': window.aiData.blockSettings},
                el ('span', {className: 'ai-block-number'},
                  props.attributes.blockNumber <= 96 ? props.attributes.blockNumber : ''
                ),
                el ('span', {className: 'ai-block-separator'},
                  props.attributes.blockNumber <= 96 ?  '---' : ''
                ),
                el ('span', {className: 'ai-block-name-text'},
                  aiBlockData [props.attributes.blockNumber - 1]['name']
                ),
              ),
            )
          )
        )
      ];
    },

    save: function () {
      return null; // render_callback handles frontend output
    },
  });
} (
  window.wp.blocks,
  window.wp.element,
  window.wp.blockEditor,
  window.wp.components
)
);
