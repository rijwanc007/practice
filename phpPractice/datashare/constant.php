<?php

define('HOST','localhost');
define('USER','root');
define('PASSWORD','roott123');
define('DB','cc');  
define("API_USER", "fortis2244");
define("API_PASSWORD", "GLXS_FoRTiSa!!YHRs@6");
define('DATA_FETCH_LIMIT',30000);

define('INBOUND_SKILL',['AH', 'AA', 'AB', 'AG', 'AI', 'AJ', 'Ak', 'AL', 'AF']);

define('DISC_PARTY',[
    'A' => 'Agent',
    'C' => 'Customer',
    'S' => 'Systems',
    'T' => 'Transfer',
    'I' => 'IVR',
    'Q' => 'Queue',
    'E' => 'Low Balance'
]);

define('TRANSFER_TYPE',[
    'A' =>'Agent',
    'I' =>'IVR',
    'Q' =>'Skill'
]);

define('DISC_MSG',[
    '708' => 'Ring Timeout',
    '750' => 'Session Expired',
    '770' => 'Agent Logout - Call Control',
    '774' => 'Agent Logout - Soft Phone',
    '716' => 'RTP Timeout',
    '780' => 'Factory Reset',
    '784' => 'Soft Phone Close',
    '788' => 'Unregister',
    '712' => 'Invite Timeout',
    '700' => 'Agent Hangup',
    '200' => 'OK',
    '19' => 'No answer from user (user alerted)',
    '31' => 'Normal, unspecified',
    '20' => 'Subscriber absent',
    '1' => 'Unallocated (unassigned) number',
    '702'=> 'Agent Hangup Using Hotkey'
]);