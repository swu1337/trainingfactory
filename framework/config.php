<?php
const BASE_NAMESPACE = 'dev\\';
const DATA_SOURCE_NAME = 'mysql:dbname=trainingfactory;host=127.0.0.1;charset=utf8';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';
const DEFAULT_ROLE = 'bezoeker';
const IMAGE_LOCATION = 'img/';

const REQUEST_SUCCESS = 1;
const REQUEST_FAILURE_DATA_INVALID = 2;
const REQUEST_FAILURE_DATA_INCOMPLETE = 3;
const REQUEST_NOTHING_CHANGED = 4;
const REQUEST_NO_DATA = 5;

const IMAGE_NOTHING_UPLOADED = 6;
const IMAGE_FAILURE_SIZE_EXCEEDED = 7;
const IMAGE_FAILURE_TYPE = 8;
const IMAGE_SUCCESS = 9;

const IMAGE_FAILURE_SAVE_FAILED = 10;
const DB_NOT_ACCEPTABLE_DATA = 11;

const VIEW_PATH = 'dev/view/templates/';

const PARAM_URL_INVALID = 12;
const PARAM_URL_INCOMPLETE = 13;
