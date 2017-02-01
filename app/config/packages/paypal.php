<?php
return array(
    // set your paypal credential
    'client_id' => 'AeismjLNxPkgumvTBqG_mJ8gOxJdwJZAREiapmCrti_4t_FdGao3S9H3Wqd0UWAwjS7gbiV51o6bFUAz',
    'secret' => 'ED8nAGat604-AdJk8LhMSZ2ro-AfG0hg5W_oD91peIp2wphsgEiA84ThrqxHlzAp3HUXjTGm2JUWFut1',

    /**
     * SDK configuration 
     */
    'settings' => array(
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => 'sandbox',

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'FINE'
    ),
);