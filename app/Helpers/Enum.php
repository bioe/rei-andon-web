<?php
//Register at AppServiceProvider

//ENV
const LOGIN_USERNAME = 'LOGIN_USERNAME';
const REI = "REI";
const WATCH = "WATCH";
const WEB = "WEB";
const HELP = "HELP";


const ADMIN = 'ADMIN';
const ENGINEER = 'ENGINEER';
const TECHNICIAN = 'TECHNICIAN';
const OPERATOR = 'OPERATOR';

const MORNING = 'MORNING';
const NIGHT = 'NIGHT';

//TODO:Move to Setting 
const LATEST_RECORD_VIEW_MINUTE = 15;
const DASHBOARD_REFRESH_SECOND = 5;
const JOB_COMPLETE_AFTER_MINUTE = 30; //User will receive new record after the existing record is over x minute and did not update completed_at 

//MQTT USE IN REI
const TOPIC_RESPONSE = "andon/response";
const TOPIC_COMPLETE = "andon/complete";
const TOPIC_HELP = "andon/help";

//MQTT USE IN WATCH
const TOPIC_HEARTBEAT = "watch/heartbeat";
const TOPIC_NOTIFICATION = "watch/notification";
const TOPIC_LOGIN = "watch/login"; //watch/login/{watch_code}

//WATCH LOGIN MODE
const WATCH_LOGIN_WEB = "WEB"; //Require to Accept Login in the watch
const WATCH_LOGIN_BADGE = "BADGE"; //Skip Accept Login in the watch
