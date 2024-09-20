<?php
//Register at AppServiceProvider

//ENV
const LOGIN_USERNAME = 'LOGIN_USERNAME';
const REI = "REI";
const WATCH = "WATCH";
const WEB = "WEB";

const ADMIN = 'ADMIN';
const ENGINEER = 'ENGINEER';
const OPERATOR = 'OPERATOR';

const MORNING = 'MORNING';
const NIGHT = 'NIGHT';

//TODO:Move to Setting 
const LATEST_RECORD_VIEW_MINUTE = 15;
const DASHBOARD_REFRESH_SECOND = 5;

//MQTT
const TOPIC_NOTIFICATION = "andon/notification";
const TOPIC_RESPONSE = "andon/response";
const TOPIC_HEARTBEAT = "andon/heartbeat";
const TOPIC_LOGIN = "andon/login"; //andon/login/{watch_code}

//WATCH LOGIN MODE
const WATCH_LOGIN_WEB = "WEB"; //Require to Accept Login in the watch
const WATCH_LOGIN_BADGE = "BADGE"; //Skip Accept Login in the watch
