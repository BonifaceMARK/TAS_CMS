<?php

if (!function_exists('getStatusColor')) {
    function getStatusColor($status) {
        switch ($status) {
            case 'closed':
                return '#99ff99'; // light green
            case 'in-progress':
                return '#ffffcc'; // light yellow
            case 'settled':
                return '#ccffcc'; // light green
            case 'unsettled':
                return '#ffcccc'; // light red
            default:
                return '#ffffff'; // default color
        }
    }
}

// Define other helper functions as needed...

