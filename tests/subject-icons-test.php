<?php
/** Isolated subject icon regression checks; no WordPress boot needed. */
if ( PHP_SAPI !== 'cli' ) { exit; }
function get_the_title( $title ) { return $title; }
function wp_strip_all_tags( $value ) { return strip_tags( $value ); }

$source = file_get_contents( __DIR__ . '/../themes/kleo-child/functions.php' );
$start = strpos( $source, 'function classhall_get_sensei_course_icon_class(' );
$end = strpos( $source, 'function classhall_get_sensei_course_icon_svg(' );
if ( false === $start || false === $end ) { throw new RuntimeException( 'Icon functions not found.' ); }
eval( substr( $source, $start, $end - $start ) );

$cases = array(
    'Livestock Farming - SS1' => 'animal',
    'Animal Husbandry - SS2' => 'animal',
    'Poultry Farming' => 'animal',
    'Agricultural Science - JSS1' => 'agriculture',
    'Crop Farming' => 'agriculture',
    'Home Economics - JSS2' => 'home',
    'Economics - SS1' => 'economics',
    'Physical and Health Education' => 'physical',
    'Health Education' => 'health',
    'Mathematics - Primary 1' => 'math',
    'Government - SS2' => 'government',
    'Biology' => 'biology',
    'Physics' => 'physics',
    'Chemistry' => 'science',
    'Computer Hardware' => 'hardware',
    'Computer Science/ICT' => 'computer',
    'Literature in English' => 'literature',
    'Cultural and Creative Arts' => 'arts',
    'Yoruba' => 'language',
    'Igbo' => 'language',
    'Hausa' => 'language',
    'Unlisted Subject' => 'default',
    'Artificial Intelligence' => 'default',
);
$font = file_get_contents( __DIR__ . '/../themes/kleo/assets/font-all/css/fontello.css' );
foreach ( $cases as $title => $expected ) {
    $actual = classhall_get_sensei_course_icon_type( $title );
    if ( $actual !== $expected ) { throw new RuntimeException( "$title: expected $expected, got $actual" ); }
    $icon = explode( ' ', classhall_get_sensei_course_icon_class( $actual ) )[0];
    if ( false === strpos( $font, '.' . $icon . ':before' ) ) { throw new RuntimeException( "Missing glyph: $icon" ); }
}
if ( 'icon-leaf' === classhall_get_sensei_course_icon_class( 'animal' ) ) {
    throw new RuntimeException( 'Animal subjects must not use a leaf.' );
}
echo "PASS: Subject matching, precedence and icon glyph availability.\n";
