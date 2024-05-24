<?php
//Register at AppServiceProvider

//ENV
const LOGIN_USERNAME = 'LOGIN_USERNAME';
const REI = "REI";
const WATCH = "WATCH";
const WEB = "WEB";

const ADMIN = 'ADMIN';
const OPERATOR = 'OPERATOR';

const MORNING = 'MORNING';
const NIGHT = 'NIGHT';

//TODO:Move to Setting 
const LATEST_RECORD_VIEW_MINUTE = 3;
const DASHBOARD_REFRESH_SECOND = 10;

//MQTT
const TOPIC_NOTIFICATION = "andon/notification";
const TOPIC_RESPONSE = "andon/response";
const TOPIC_HEARTBEAT = "andon/heartbeat";
