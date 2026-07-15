<?php
// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration
$num_iterations = 100;  // Number of times to test each watermark
$watermark_script = 'watermark.php';

// Test images array
$test_images = array(
    'JPG' => '/wp-content/uploads/wccp_pro_watermark_testing_images/JPG_500_280.jpg',
    'PNG' => '/wp-content/uploads/wccp_pro_watermark_testing_images/PNG_500_280.png',
    'GIF' => '/wp-content/uploads/wccp_pro_watermark_testing_images/GIF_500_280.gif',
    'WEBP' => '/wp-content/uploads/wccp_pro_watermark_testing_images/WEBP_500_280.webp'
);

echo "<h1>Watermark Speed Test</h1>";
echo "<p>Testing each image format {$num_iterations} times...</p>";

// Store results for each format
$format_results = array();

// Test each image format
foreach ($test_images as $format => $test_image) {
    echo "<h2>Testing {$format} Format</h2>";
    
    // Initialize variables for this format
    $total_time = 0;
    $times = array();
    
    // Run the test multiple times
    for ($i = 0; $i < $num_iterations; $i++) {
        // Start timing
        $start_time = microtime(true);
        
        // Make the request to the watermark script
        $url = "http://localhost.com/wordpress/wp-content/plugins/wccp-pro/{$watermark_script}?src={$test_image}&x={$i}";
        
        // Use cURL to make the request
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_NOBODY => true
        ));
        
        // Execute request
        curl_exec($ch);
        
        // Check for errors
        if (curl_errno($ch)) {
            echo "<p>Error on {$format} iteration {$i}: " . curl_error($ch) . "</p>";
            continue;
        }
        
        // Get HTTP response code
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // End timing
        $end_time = microtime(true);
        $execution_time = ($end_time - $start_time) * 1000; // Convert to milliseconds
        
        // Store the time
        $times[] = $execution_time;
        $total_time += $execution_time;
        
        // Output progress every 25 iterations
        if (($i + 1) % 25 === 0) {
            echo "<p>Completed " . ($i + 1) . " iterations for {$format}...</p>";
            flush();
            ob_flush();
        }
    }
    
    // Calculate statistics for this format
    $average_time = $total_time / $num_iterations;
    $min_time = min($times);
    $max_time = max($times);
    sort($times);
    $median_time = $times[floor($num_iterations/2)];
    
    // Store results for this format
    $format_results[$format] = array(
        'total' => $total_time,
        'average' => $average_time,
        'median' => $median_time,
        'min' => $min_time,
        'max' => $max_time,
        'times' => $times
    );
    
    // Output results for this format
    echo "<h3>Results for {$format}:</h3>";
    echo "<ul>";
    echo "<li>Total Time: " . number_format($total_time, 2) . " ms</li>";
    echo "<li>Average Time: " . number_format($average_time, 2) . " ms per request</li>";
    echo "<li>Median Time: " . number_format($median_time, 2) . " ms</li>";
    echo "<li>Minimum Time: " . number_format($min_time, 2) . " ms</li>";
    echo "<li>Maximum Time: " . number_format($max_time, 2) . " ms</li>";
    echo "</ul>";
    
    // Generate histogram for this format
    $histogram = array();
    $bucket_size = ($max_time - $min_time) / 10;
    foreach ($times as $time) {
        $bucket = floor(($time - $min_time) / $bucket_size);
        if (!isset($histogram[$bucket])) {
            $histogram[$bucket] = 0;
        }
        $histogram[$bucket]++;
    }
    
    echo "<h4>{$format} Response Time Distribution:</h4>";
    foreach ($histogram as $bucket => $count) {
        $start = number_format($min_time + ($bucket * $bucket_size), 2);
        $end = number_format($min_time + (($bucket + 1) * $bucket_size), 2);
        $bars = str_repeat("█", $count);
        echo "{$start}ms - {$end}ms: {$bars} ({$count})<br>";
    }
    echo "<hr>";
}

// Compare formats
echo "<h2>Format Comparison:</h2>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Format</th><th>Average Time (ms)</th><th>Median Time (ms)</th></tr>";
foreach ($format_results as $format => $results) {
    echo "<tr>";
    echo "<td>{$format}</td>";
    echo "<td>" . number_format($results['average'], 2) . "</td>";
    echo "<td>" . number_format($results['median'], 2) . "</td>";
    echo "</tr>";
}
echo "</table>";
?> 