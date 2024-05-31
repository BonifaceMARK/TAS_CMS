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



if (!function_exists('symbolBgColor')) {
    /**
     * Get the background color CSS class based on symbol status.
     *
     * @param string $symbol
     * @return string
     */
    function symbolBgColor($symbol)
    {
        switch ($symbol) {
            case 'complete':
                return 'bg-success';
            case 'incomplete':
                return 'bg-danger';
            case 'deleting':
                return 'bg-warning';
            default:
                return 'bg-secondary';
        }
    }
}


