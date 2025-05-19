<?php
function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    $data = nl2br($data);
    return $data;
}

function format_time($timestamp)
{
    $time_diff = time() - $timestamp;
    $seconds = $time_diff;
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $days = floor($hours / 24);
    $weeks = floor($days / 7);
    $months = floor($weeks / 4);
    $years = floor($months / 12);

    if ($seconds < 60) {
        return 'just now';
    } elseif ($minutes < 60) {
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ago';
    } elseif ($hours < 24) {
        return $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ago';
    } elseif ($days < 7) {
        return $days . ' day' . ($days > 1 ? 's' : '') . ' ago';
    } elseif ($weeks < 4) {
        return $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
    } elseif ($months < 12) {
        return $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
    } else {
        return date('j F Y', $timestamp);
    }
}
