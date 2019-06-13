<?php

$exit_modes = ["time-out", "suspend", "logout", ""];
$statuses = ["passed", "completed", "failed", "incomplete", "browsed", "not attempted"];

$source = $_SERVER["QUERY_STRING"];

$lesson_location = isset($_POST["lesson_location"]) ? $_POST["lesson_location"] : "0";
$suspend_data = isset($_POST["suspend_data"]) ? $_POST["suspend_data"] : "";
$lesson_status = isset($_POST["lesson_status"]) ? $_POST["lesson_status"] : "incomplete";
$core_exit = isset($_POST["core_exit"]) ? $_POST["core_exit"] : "suspend";
$score_raw = isset($_POST["score_raw"]) ? $_POST["score_raw"] : "";

?><!DOCTYPE html>
<html dir="ltr" lang="en" xml:lang="en" class="yui3-js-enabled">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>courses.dev : 1.2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
<script
  src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
  integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8="
  crossorigin="anonymous"></script>
<style>
html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}main{display:block}h1{font-size:2em;margin:.67em 0}hr{box-sizing:content-box;height:0;overflow:visible}pre{font-family:monospace,monospace;font-size:1em}a{background-color:transparent}abbr[title]{border-bottom:none;text-decoration:underline;text-decoration:underline dotted}b,strong{font-weight:bolder}code,kbd,samp{font-family:monospace,monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}img{border-style:none}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;line-height:1.15;margin:0}button,input{overflow:visible}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button}[type=button]::-moz-focus-inner,[type=reset]::-moz-focus-inner,[type=submit]::-moz-focus-inner,button::-moz-focus-inner{border-style:none;padding:0}[type=button]:-moz-focusring,[type=reset]:-moz-focusring,[type=submit]:-moz-focusring,button:-moz-focusring{outline:1px dotted ButtonText}fieldset{padding:.35em .75em .625em}legend{box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal}progress{vertical-align:baseline}textarea{overflow:auto}[type=checkbox],[type=radio]{box-sizing:border-box;padding:0}[type=number]::-webkit-inner-spin-button,[type=number]::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}[type=search]::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}details{display:block}summary{display:list-item}template{display:none}[hidden]{display:none}
body,html {height:100vh;}
body {
    font-family: sans-serif;
    position: relative;
    overflow: hidden;
}
body>header{
    display: flex;
    background-color: darkblue;
    color: white;
    align-items: center;
    height: 110px; left: 0;
    position: absolute;
    width: 100%;
}
body>header>div{
    align-items: center;
    padding: 0 1em;
}
header h1 { margin: 0; padding: 0; }
body>header>div:first-of-type{
    flex: 1;
}
body>form{
    background-color: lightblue;
    height: 204px;
    position: absolute;
    top: 110px; width: 100%;
    left: 0;
}
body>form>div{
    padding: 1em;
}

body>main {
    position: absolute;
    top: calc(204px + 110px);
    height: calc(100vh - 204px - 110px);
    width: 100vw;
    left: 0;
    display: flex;
    flex-direction: row;
}
main>aside {
    width: 250px;
    background-color: #e8e8e8;
    overflow: hidden;
    overflow-y: auto;
    font-size: 12px;
}
article {
    background-color: #dbe3e5;
    background-image: url("data:image/svg+xml,%3Csvg width='6' height='6' viewBox='0 0 6 6' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%2392a2ac' fill-opacity='0.25' fill-rule='evenodd'%3E%3Cpath d='M5 0h1L0 6V5zM6 5v1H5z'/%3E%3C/g%3E%3C/svg%3E");    position: relative;
    flex: 1;
}
article iframe {
    position: absolute;
    top: 1em;
    left: 1em;
    width: calc(100% - 2em);
    height: calc(100% - 2em);
    border: none;
    background-color: rgba(255,255,255,.5);
}
#console_log>div:nth-of-type(even) {
    background-color: white;
}
fieldset {
    border-color: #f8f8f8;
}
fieldset>legend {
    font-weight: bold;
}
</style>

<script type="text/javascript">
var proxy = function () {
        this.LMSInitialize = function() { console.log("proxy.initialise"); return "true"; },
        this.LMSFinish = function () { console.log("proxy.finish"); return "true"; },
        this.LMSGetValue = function (param) { console.log("proxy.get", param); return ""; },
        this.LMSSetValue = function (param,value) { console.log("proxy.set", param,value); return "true"; },
        this.LMSCommit = function (param) { console.log("proxy.commit", param); return "true"; },
        this.LMSGetLastError = function () { return 0; },
        this.LMSGetErrorString = function () { console.log("proxy.errorString"); return "No error"; },
        this.LMSGetDiagnostic = function (param) { console.log("proxy.diagnostic", param); return param; }
};
// rename to ninjaApiProxy to test debugging proxy
var _ninjaApiProxy = new proxy();

// http://stackoverflow.com/a/14246240/1238884
// IE8 bug: doesnt have a console until developer tools is open
(function (fallback) {

    fallback = fallback || function () { };

    // function to trap most of the console functions from the FireBug Console API.
    var trap = function () {
        // create an Array from the arguments Object
        var args = Array.prototype.slice.call(arguments);
        var message = args.join(' ');
        console.messages.push(message);
        fallback(message);
    };

    // redefine console
    if (typeof console === 'undefined') {
        console = {
            messages: [],
            dump: function() { return console.messages.join('\n'); },
            log: trap,
            debug: trap,
            info: trap,
            warn: trap,
            error: trap,
            assert: trap,
            clear: function() { console.messages.length = 0 },
            dir: trap,
            dirxml: trap,
            trace: trap,
            group: trap,
            groupCollapsed: trap,
            groupEnd: trap,
            time: trap,
            timeEnd: trap,
            timeStamp: trap,
            profile: trap,
            profileEnd: trap,
            count: trap,
            exception: trap,
            table: trap
        };
    }

})(null); // to define a fallback function, replace null with the name of the function (ex: alert)


//
// SCORM 1.2 API Simulation
// e.g. this works like the server side component of a 1.2 compatible lms, but doesn't actually transmit data
// any commit / finish / save calls are just sent to the browser console.
//
function SCORMapi1_2() {

    var _this = this;

    // Standard Data Type Definition
    CMIString256 = '^[\\u0000-\\uffff]{0,255}$';
    CMIString4096 = '^[\\u0000-\\uffff]{0,4096}$';
    CMITime = '^([0-2]{1}[0-9]{1}):([0-5]{1}[0-9]{1}):([0-5]{1}[0-9]{1})(\.[0-9]{1,2})?$';
    CMITimespan = '^([0-9]{2,4}):([0-9]{2}):([0-9]{2})(\.[0-9]{1,2})?$';
    CMIInteger = '^\\d+$';
    CMISInteger = '^-?([0-9]+)$';
    CMIDecimal = '^-?([0-9]{0,3})(\.[0-9]{1,2})?$';
    CMIIdentifier = '^[\\u0021-\\u007E]{0,255}$';
    CMIFeedback = CMIString256; // This must be redefined
    CMIIndex = '[._](\\d+).';

    // Vocabulary Data Type Definition
    CMIStatus = '^passed$|^completed$|^failed$|^incomplete$|^browsed$';
    CMIStatus2 = '^passed$|^completed$|^failed$|^incomplete$|^browsed$|^not attempted$';
    CMIExit = '^time-out$|^suspend$|^logout$|^$';
    CMIType = '^true-false$|^choice$|^fill-in$|^matching$|^performance$|^sequencing$|^likert$|^numeric$';
    CMIResult = '^correct$|^wrong$|^unanticipated$|^neutral$|^([0-9]{0,3})?(\.[0-9]{1,2})?$';
    NAVEvent = '^previous$|^continue$';

    // Children lists
    cmi_children = 'core,suspend_data,launch_data,comments,objectives,student_data,student_preference,interactions';
    core_children = 'student_id,student_name,lesson_location,credit,lesson_status,entry,score,total_time,lesson_mode,exit,session_time';
    score_children = 'raw,min,max';
    comments_children = 'content,location,time';
    objectives_children = 'id,score,status';
    correct_responses_children = 'pattern';
    student_data_children = 'mastery_score,max_time_allowed,time_limit_action';
    student_preference_children = 'audio,language,speed,text';
    interactions_children = 'id,objectives,time,type,correct_responses,weighting,student_response,result,latency';

    // Data ranges
    score_range = '0#100';
    audio_range = '-1#100';
    speed_range = '-100#100';
    weighting_range = '-100#100';
    text_range = '-1#1';

    // The SCORM 1.2 data model
    var datamodel =  {
        'cmi._children':{'defaultvalue':cmi_children, 'mod':'r', 'writeerror':'402'},
        'cmi._version':{'defaultvalue':'3.4', 'mod':'r', 'writeerror':'402'},
        'cmi.core._children':{'defaultvalue':core_children, 'mod':'r', 'writeerror':'402'},
        'cmi.core.student_id':{'defaultvalue':'u2455', 'mod':'r', 'writeerror':'403'},
        'cmi.core.student_name':{'defaultvalue':'Hambly-Clark, Kay', 'mod':'r', 'writeerror':'403'},
        'cmi.core.credit':{'defaultvalue':'credit', 'mod':'r', 'writeerror':'403'},
        'cmi.core.entry':{'defaultvalue':'resume', 'mod':'r', 'writeerror':'403'},
        'cmi.core.score._children':{'defaultvalue':score_children, 'mod':'r', 'writeerror':'402'},
        'cmi.core.score.raw':{'defaultvalue':'', 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.core.score.max':{'defaultvalue':'', 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.core.score.min':{'defaultvalue':'', 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.core.total_time':{'defaultvalue':'00:08:35.00', 'mod':'r', 'writeerror':'403'},
        'cmi.core.lesson_mode':{'defaultvalue':'normal', 'mod':'r', 'writeerror':'403'},
        'cmi.core.session_time':{'format':CMITimespan, 'mod':'w', 'defaultvalue':'00:00:00', 'readerror':'404', 'writeerror':'405'},
<?php
    echo PHP_EOL;
    echo "        'cmi.core.lesson_location':{'defaultvalue':'$lesson_location', 'format':CMIString256, 'mod':'rw', 'writeerror':'405'}," . PHP_EOL;
    echo "        'cmi.suspend_data':{'defaultvalue':'$suspend_data', 'format':CMIString4096, 'mod':'rw', 'writeerror':'405'}," . PHP_EOL;
    echo "        'cmi.core.exit':{'defaultvalue':'$core_exit', 'format':CMIExit, 'mod':'w', 'readerror':'404', 'writeerror':'405'}," . PHP_EOL;
    echo "        'cmi.core.lesson_status':{'defaultvalue':'$lesson_status', 'format':CMIStatus, 'mod':'rw', 'writeerror':'405'}," . PHP_EOL;
    echo "        'cmi.core.score.raw':{'defaultvalue':'$score_raw', 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'}," . PHP_EOL;
    echo PHP_EOL;
?>
        'cmi.launch_data':{'defaultvalue':'', 'mod':'r', 'writeerror':'403'},
        'cmi.comments':{'defaultvalue':'', 'format':CMIString4096, 'mod':'rw', 'writeerror':'405'},
        // deprecated evaluation attributes
        'cmi.evaluation.comments._count':{'defaultvalue':'0', 'mod':'r', 'writeerror':'402'},
        'cmi.evaluation.comments._children':{'defaultvalue':comments_children, 'mod':'r', 'writeerror':'402'},
        'cmi.evaluation.comments.n.content':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIString256, 'mod':'rw', 'writeerror':'405'},
        'cmi.evaluation.comments.n.location':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIString256, 'mod':'rw', 'writeerror':'405'},
        'cmi.evaluation.comments.n.time':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMITime, 'mod':'rw', 'writeerror':'405'},
        'cmi.comments_from_lms':{'mod':'r', 'writeerror':'403'},
        'cmi.objectives._children':{'defaultvalue':objectives_children, 'mod':'r', 'writeerror':'402'},
        'cmi.objectives._count':{'mod':'r', 'defaultvalue':'0', 'writeerror':'402'},
        'cmi.objectives.n.id':{'pattern':CMIIndex, 'format':CMIIdentifier, 'mod':'rw', 'writeerror':'405'},
        'cmi.objectives.n.score._children':{'pattern':CMIIndex, 'mod':'r', 'writeerror':'402'},
        'cmi.objectives.n.score.raw':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.objectives.n.score.min':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.objectives.n.score.max':{'defaultvalue':'', 'pattern':CMIIndex, 'format':CMIDecimal, 'range':score_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.objectives.n.status':{'pattern':CMIIndex, 'format':CMIStatus2, 'mod':'rw', 'writeerror':'405'},
        'cmi.student_data._children':{'defaultvalue':student_data_children, 'mod':'r', 'writeerror':'402'},
        'cmi.student_data.mastery_score':{'defaultvalue':'', 'mod':'r', 'writeerror':'403'},
        'cmi.student_data.max_time_allowed':{'defaultvalue':'', 'mod':'r', 'writeerror':'403'},
        'cmi.student_data.time_limit_action':{'defaultvalue':'', 'mod':'r', 'writeerror':'403'},
        'cmi.student_preference._children':{'defaultvalue':student_preference_children, 'mod':'r', 'writeerror':'402'},
        'cmi.student_preference.audio':{'defaultvalue':'0', 'format':CMISInteger, 'range':audio_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.student_preference.language':{'defaultvalue':'', 'format':CMIString256, 'mod':'rw', 'writeerror':'405'},
        'cmi.student_preference.speed':{'defaultvalue':'0', 'format':CMISInteger, 'range':speed_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.student_preference.text':{'defaultvalue':'0', 'format':CMISInteger, 'range':text_range, 'mod':'rw', 'writeerror':'405'},
        'cmi.interactions._children':{'defaultvalue':interactions_children, 'mod':'r', 'writeerror':'402'},
        'cmi.interactions._count':{'mod':'r', 'defaultvalue':'0', 'writeerror':'402'},
        'cmi.interactions.n.id':{'pattern':CMIIndex, 'format':CMIIdentifier, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.objectives._count':{'pattern':CMIIndex, 'mod':'r', 'defaultvalue':'0', 'writeerror':'402'},
        'cmi.interactions.n.objectives.n.id':{'pattern':CMIIndex, 'format':CMIIdentifier, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.time':{'pattern':CMIIndex, 'format':CMITime, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.type':{'pattern':CMIIndex, 'format':CMIType, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.correct_responses._count':{'pattern':CMIIndex, 'mod':'r', 'defaultvalue':'0', 'writeerror':'402'},
        'cmi.interactions.n.correct_responses.n.pattern':{'pattern':CMIIndex, 'format':CMIFeedback, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.weighting':{'pattern':CMIIndex, 'format':CMIDecimal, 'range':weighting_range, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.student_response':{'pattern':CMIIndex, 'format':CMIFeedback, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.result':{'pattern':CMIIndex, 'format':CMIResult, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'cmi.interactions.n.latency':{'pattern':CMIIndex, 'format':CMITimespan, 'mod':'w', 'readerror':'404', 'writeerror':'405'},
        'nav.event':{'defaultvalue':'', 'format':NAVEvent, 'mod':'w', 'readerror':'404', 'writeerror':'405'}
    };


    //
    // Datamodel inizialization
    //
    var cmi = new Object();
        cmi.core = new Object();
        cmi.core.score = new Object();
        cmi.objectives = new Object();
        cmi.student_data = new Object();
        cmi.student_preference = new Object();
        cmi.interactions = new Object();
        // deprecated evaluation attributes
        cmi.evaluation = new Object();
        cmi.evaluation.comments = new Object();

    // Navigation Object
    var nav = new Object();

    for (element in datamodel) {
        if (element.match(/\.n\./) == null) {
            if ((typeof eval('datamodel["'+element+'"].defaultvalue')) != 'undefined') {
                eval(element+' = datamodel["'+element+'"].defaultvalue;');
            } else {
                eval(element+' = "";');
            }
        }
    }


    if (cmi.core.lesson_status == '') {
        cmi.core.lesson_status = 'not attempted';
    }

    //
    // API Methods definition
    //
    var Initialized = false;

    function LMSInitialize (param) {
        errorCode = "0";
scormLog("LMSInitialize",param);
        if (param == "") {
            if (!Initialized) {
                Initialized = true;
                errorCode = "0";
                                return "true";
            } else {
                errorCode = "101";
            }
        } else {
            errorCode = "201";
        }
                return "false";
    }

    function LMSFinish (param) {
        errorCode = "0";
scormLog("LMSFinish",param);
        if (param == "") {
            if (Initialized) {
                Initialized = false;
                result = StoreData(cmi,true);
                if (nav.event != '') {
                    if (nav.event == 'continue') {
                        setTimeout('mod_scorm_launch_next_sco();',500);
                    } else {
                        setTimeout('mod_scorm_launch_prev_sco();',500);
                    }
                } else {
                    if (0 == 1) {
                        setTimeout('mod_scorm_launch_next_sco();',500);
                    }
                }
                result = ('true' == result) ? 'true' : 'false';
                errorCode = (result == 'true')? '0' : '101';
                                // trigger TOC update
                // var sURL = "/http://moodle25" + "/mod/scorm/prereqs.php?a=5&scoid=12&attempt=1&mode=&currentorg=&sesskey=YoiI0DYj13";
                //var callback = M.mod_scorm.connectPrereqCallback;
                console.log("LMSFinish Callback", cmi, result, errorCode);
                //YUI().use('yui2-connection', function(Y) {
                //    Y.YUI2.util.Connect.asyncRequest('GET', sURL, callback, null);
                //});
                return result;
            } else {
                errorCode = "301";
            }
        } else {
            errorCode = "201";
        }
                return "false";
    }

    function LMSGetValue (element) {
        // console.log("LMSGetValue", element, datamodel);
        errorCode = "0";
        if (Initialized) {
            if (element !="") {
                expression = new RegExp(CMIIndex,'g');
                elementmodel = String(element).replace(expression,'.n.');
                if ((typeof eval('datamodel["'+elementmodel+'"]')) != "undefined") {
                    if (eval('datamodel["'+elementmodel+'"].mod') != 'w') {
                        element = String(element).replace(expression, "_$1.");
                        elementIndexes = element.split('.');
                        subelement = 'cmi';
                        i = 1;
                        while ((i < elementIndexes.length) && (typeof eval(subelement) != "undefined")) {
                            subelement += '.'+elementIndexes[i++];
                        }
                            if (subelement == element) {
                            errorCode = "0"; // console.log("return", element, eval(element));
                                                        return eval(element);
                        } else {
                            errorCode = "0"; // Need to check if it is the right errorCode
                        }
                    } else {
                        errorCode = eval('datamodel["'+elementmodel+'"].readerror');
                    }
                } else {
                    childrenstr = '._children';
                    countstr = '._count';
                    if (elementmodel.substr(elementmodel.length-childrenstr.length,elementmodel.length) == childrenstr) {
                        parentmodel = elementmodel.substr(0,elementmodel.length-childrenstr.length);
                        if ((typeof eval('datamodel["'+parentmodel+'"]')) != "undefined") {
                            errorCode = "202";
                        } else {
                            errorCode = "201";
                        }
                    } else if (elementmodel.substr(elementmodel.length-countstr.length,elementmodel.length) == countstr) {
                        parentmodel = elementmodel.substr(0,elementmodel.length-countstr.length);
                        if ((typeof eval('datamodel["'+parentmodel+'"]')) != "undefined") {
                            errorCode = "203";
                        } else {
                            errorCode = "201";
                        }
                    } else {
                        errorCode = "201";
                    }
                }
            } else {
                errorCode = "201";
            }
        } else {
            errorCode = "301";
        }
                return "";
    }

    function LMSSetValue (element,value) {
      console.log("API LMS SET VALUE", element, value);
scormLog("LMSSetValue", element,value);
        errorCode = "0";
        if (Initialized) {
            if (element != "") {
                expression = new RegExp(CMIIndex,'g');
                elementmodel = String(element).replace(expression,'.n.');
                if ((typeof eval('datamodel["'+elementmodel+'"]')) != "undefined") {
                    if (eval('datamodel["'+elementmodel+'"].mod') != 'r') {
                        expression = new RegExp(eval('datamodel["'+elementmodel+'"].format'));
                        value = value+'';
                        matches = value.match(expression);
                        if (matches != null) {
                            //Create dynamic data model element
                            if (element != elementmodel) {
                                elementIndexes = element.split('.');
                                subelement = 'cmi';
                                for (i=1;i < elementIndexes.length-1;i++) {
                                    elementIndex = elementIndexes[i];
                                    if (elementIndexes[i+1].match(/^\d+$/)) {
                                        if ((typeof eval(subelement+'.'+elementIndex)) == "undefined") {
                                            eval(subelement+'.'+elementIndex+' = new Object();');
                                            eval(subelement+'.'+elementIndex+'._count = 0;');
                                        }
                                        if (elementIndexes[i+1] == eval(subelement+'.'+elementIndex+'._count')) {
                                            eval(subelement+'.'+elementIndex+'._count++;');
                                        }
                                        if (elementIndexes[i+1] > eval(subelement+'.'+elementIndex+'._count')) {
                                            errorCode = "201";
                                        }
                                        subelement = subelement.concat('.'+elementIndex+'_'+elementIndexes[i+1]);
                                        i++;
                                    } else {
                                        subelement = subelement.concat('.'+elementIndex);
                                    }
                                    if ((typeof eval(subelement)) == "undefined") {
                                        eval(subelement+' = new Object();');
                                        if (subelement.substr(0,14) == 'cmi.objectives') {
                                            eval(subelement+'.score = new Object();');
                                            eval(subelement+'.score._children = score_children;');
                                            eval(subelement+'.score.raw = "";');
                                            eval(subelement+'.score.min = "";');
                                            eval(subelement+'.score.max = "";');
                                        }
                                        if (subelement.substr(0,16) == 'cmi.interactions') {
                                            eval(subelement+'.objectives = new Object();');
                                            eval(subelement+'.objectives._count = 0;');
                                            eval(subelement+'.correct_responses = new Object();');
                                            eval(subelement+'.correct_responses._count = 0;');
                                        }
                                    }
                                }
                                element = subelement.concat('.'+elementIndexes[elementIndexes.length-1]);
                            }
                            //console.log("p",errorCode,element,value);
                            //Store data
                            if (errorCode == "0") {
                                if ((typeof eval('datamodel["'+elementmodel+'"].range')) != "undefined") {
                                    range = eval('datamodel["'+elementmodel+'"].range');
                                    ranges = range.split('#');
                                    value = value*1.0;
                                    if ((value >= ranges[0]) && (value <= ranges[1])) {
                                        eval(element+'=value;');
                                        errorCode = "0";
                                    //    console.log(1, "lms set value", element, value);
                                                                                return "true";
                                    } else {
                                        errorCode = eval('datamodel["'+elementmodel+'"].writeerror');
                                    }
                                } else {
                                    if (element == 'cmi.comments') {
                                        cmi.comments = cmi.comments + value;
                                    } else {
                                        eval(element+'=value;');
                                     //   console.log("q",element,value.length);
                                    }
                                    errorCode = "0";
                                    //    console.log(2, "lms set value", element, value);
                                    //                                    return "true";
                                }
                            }
                        } else {
                            errorCode = eval('datamodel["'+elementmodel+'"].writeerror');
                        }
                    } else {
                        errorCode = eval('datamodel["'+elementmodel+'"].writeerror');
                    }
                } else {
                    errorCode = "201"
                }
            } else {
                errorCode = "201";
            }
        } else {
            errorCode = "301";
        }

        var field = "";
        switch (element) {
            case "cmi.core.exit":
                field = "core_exit"; break;
            case "cmi.suspend_data":
                field = "suspend_data"; break;
            case "cmi.core.score.raw":
                field = "score_raw"; break;
            case "cmi.core.lesson_location":
                field = "lesson_location"; break;
            case "cmi.core.lesson_status":
                field = "lesson_status"; break;
            break;

        }
        if (field.length) document.querySelector("form [name='" + field + "']").value = value;
        document.querySelector("#lastError").value = errorCode;

       return (errorCode === "0") ? "true" : "false";
    }

    function LMSCommit (param) {
        errorCode = "0";
scormLog("LMSCommit",param);
        if (param == "") {
            if (Initialized) {
                result = StoreData(cmi,false);
                // trigger TOC update
                // var sURL = "http://moodle25" + "/mod/scorm/prereqs.php?a=5&scoid=12&attempt=1&mode=&currentorg=&sesskey=YoiI0DYj13";
                // console.log("LMSCommit", sURL, result);
                //var callback = M.mod_scorm.connectPrereqCallback;
                //YUI().use('yui2-connection', function(Y) {
                //    Y.YUI2.util.Connect.asyncRequest('GET', sURL, callback, null);
                //});
                //                                result = ('true' == result) ? 'true' : 'false';
                result = true;
                errorCode = (result =='true')? '0' : '101';
                                return result;
            } else {
                errorCode = "301";
            }
        } else {
            errorCode = "201";
        }
                return "false";
    }

    function LMSGetLastError () {
             return errorCode;
    }

    function LMSGetErrorString (param) {
        if (param != "") {
            var errorString = new Array();
            errorString["0"] = "No error";
            errorString["101"] = "General exception";
            errorString["201"] = "Invalid argument error";
            errorString["202"] = "Element cannot have children";
            errorString["203"] = "Element not an array - cannot have count";
            errorString["301"] = "Not initialized";
            errorString["401"] = "Not implemented error";
            errorString["402"] = "Invalid set value, element is a keyword";
            errorString["403"] = "Element is read only";
            errorString["404"] = "Element is write only";
            errorString["405"] = "Incorrect data type";
                        return errorString[param];
        } else {
                      return "";
        }
    }

    function LMSGetDiagnostic (param) {
        if (param == "") {
            param = errorCode;
        }
                return param;
    }

    function AddTime (first, second) {
        var sFirst = first.split(":");
        var sSecond = second.split(":");
        var cFirst = sFirst[2].split(".");
        var cSecond = sSecond[2].split(".");
        var change = 0;

        FirstCents = 0;  //Cents
        if (cFirst.length > 1) {
            FirstCents = parseInt(cFirst[1],10);
        }
        SecondCents = 0;
        if (cSecond.length > 1) {
            SecondCents = parseInt(cSecond[1],10);
        }
        var cents = FirstCents + SecondCents;
        change = Math.floor(cents / 100);
        cents = cents - (change * 100);
        if (Math.floor(cents) < 10) {
            cents = "0" + cents.toString();
        }

        var secs = parseInt(cFirst[0],10)+parseInt(cSecond[0],10)+change;  //Seconds
        change = Math.floor(secs / 60);
        secs = secs - (change * 60);
        if (Math.floor(secs) < 10) {
            secs = "0" + secs.toString();
        }

        mins = parseInt(sFirst[1],10)+parseInt(sSecond[1],10)+change;   //Minutes
        change = Math.floor(mins / 60);
        mins = mins - (change * 60);
        if (mins < 10) {
            mins = "0" + mins.toString();
        }

        hours = parseInt(sFirst[0],10)+parseInt(sSecond[0],10)+change;  //Hours
        if (hours < 10) {
            hours = "0" + hours.toString();
        }

        if (cents != '0') {
            return hours + ":" + mins + ":" + secs + '.' + cents;
        } else {
            return hours + ":" + mins + ":" + secs;
        }
    }

    function TotalTime() {
        total_time = AddTime(cmi.core.total_time, cmi.core.session_time);
        return '&'+underscore('cmi.core.total_time')+'='+encodeURIComponent(total_time);
    }

    function CollectData(data,parent) {
        var datastring = '';
        for (property in data) {
            if (typeof data[property] == 'object') {
                datastring += CollectData(data[property],parent+'.'+property);
            } else {
                element = parent+'.'+property;
                expression = new RegExp(CMIIndex,'g');

                // get the generic name for this element (e.g. convert 'cmi.interactions.1.id' to 'cmi.interactions.n.id')
                elementmodel = String(element).replace(expression,'.n.');

                // ignore the session time element
                if (element != "cmi.core.session_time") {

                    // check if this specific element is not defined in the datamodel,
                    // but the generic element name is
                    if ((eval('typeof datamodel["'+element+'"]')) == "undefined"
                        && (eval('typeof datamodel["'+elementmodel+'"]')) != "undefined") {

                        // add this specific element to the data model (by cloning
                        // the generic element) so we can track changes to it
                        eval('datamodel["'+element+'"]=CloneObj(datamodel["'+elementmodel+'"]);');
                    }

                    // check if the current element exists in the datamodel
                    if ((typeof eval('datamodel["'+element+'"]')) != "undefined") {

                        // make sure this is not a read only element
                        if (eval('datamodel["'+element+'"].mod') != 'r') {

                            elementstring = '&'+underscore(element)+'='+encodeURIComponent(data[property]);

                            // check if the element has a default value
                            if ((typeof eval('datamodel["'+element+'"].defaultvalue')) != "undefined") {

                                // check if the default value is different from the current value
                                if (eval('datamodel["'+element+'"].defaultvalue') != data[property]
                                    || eval('typeof(datamodel["'+element+'"].defaultvalue)') != typeof(data[property])) {

                                    // append the URI fragment to the string we plan to commit
                                    datastring += elementstring;

                                    // update the element default to reflect the current committed value
                                    eval('datamodel["'+element+'"].defaultvalue=data[property];');
                                }
                            } else {
                                // append the URI fragment to the string we plan to commit
                                datastring += elementstring;
                                // no default value for the element, so set it now
                                eval('datamodel["'+element+'"].defaultvalue=data[property];');
                            }
                        }
                    }
                }
            }
        }
        return datastring;
    }

    function CloneObj(obj){
        if(obj == null || typeof(obj) != 'object') {
            return obj;
        }

        var temp = new obj.constructor(); // changed (twice)
        for(var key in obj) {
            temp[key] = CloneObj(obj[key]);
        }

        return temp;
    }

    function StoreData(data,storetotaltime) {
        if (storetotaltime) {
            if (cmi.core.lesson_status == 'not attempted') {
                cmi.core.lesson_status = 'completed';
            }
            if (cmi.core.lesson_mode == 'normal') {
                if (cmi.core.credit == 'credit') {
                    if (cmi.student_data.mastery_score !== '' && cmi.core.score.raw !== '') {
                        if (parseFloat(cmi.core.score.raw) >= parseFloat(cmi.student_data.mastery_score)) {
                            cmi.core.lesson_status = 'passed';
                        } else {
                            cmi.core.lesson_status = 'failed';
                        }
                    }
                }
            }
            if (cmi.core.lesson_mode == 'browse') {
                if (datamodel['cmi.core.lesson_status'].defaultvalue == '' && cmi.core.lesson_status == 'not attempted') {
                    cmi.core.lesson_status = 'browsed';
                }
            }
            datastring = CollectData(data,'cmi');
            datastring += TotalTime();
        } else {
            datastring = CollectData(data,'cmi');
        }
        datastring += '&attempt=1';
        datastring += '&scoid=12';

        // var myRequest = NewHttpReq();
        // console.log("http://.../mod/scorm/datamodel.php" + "id=0&a=5&sesskey=YoiI0DYj13"+datastring);
        //alert('going to:' + "http://moodle25/mod/scorm/datamodel.php" + "id=0&a=5&sesskey=YoiI0DYj13"+datastring);
        //console.log("StoreData",datastring,cmi);
        scormLog("StoreData",cmi);
        // result = DoRequest(null,"http://moodle25/mod/scorm/datamodel.php","id=0&a=5&sesskey=YoiI0DYj13"+datastring);
        //results = String(result).split('\n');
        errorCode = 0; //results[1];
        return ""; // results[0];
    }

    this.LMSInitialize = LMSInitialize;
    this.LMSFinish = LMSFinish;
    this.LMSGetValue = LMSGetValue;
    this.LMSSetValue = LMSSetValue;
    this.LMSCommit = LMSCommit;
    this.LMSGetLastError = LMSGetLastError;
    this.LMSGetErrorString = LMSGetErrorString;
    this.LMSGetDiagnostic = LMSGetDiagnostic;

    this.internalState = datamodel;
}

var API = new SCORMapi1_2();

function DoRequest(ignore, url, data) {

    // var xhr = new XMLHttpRequest();
    // xhr.open("POST", "http://logger.dev/index.php", true);
    // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // xhr.onreadystatechange = function() {
    //     if (xhr.readyState == 4 && xhr.status == 200) {
     //       console.log("DoRequest -> POST", url, data);
    //    }
    // }
    // xhr.send(data);
}


var errorCode = "0";
function underscore(str) {
    str = String(str).replace(/.N/g,".");
    return str.replace(/\./g,"__");
}

function addMarker() {
    var output = document.getElementById("console_log");
    var el = document.createElement("div");
    el.setAttribute("style","background-color:red");
    var now = new Date(), h = now.getHours(), m = now.getMinutes(), s = now.getSeconds();
    el.innerHTML = [h<10?"0"+h:h,m<10?"0"+m:m,s<10?"0"+s:s," "].join(":") + " - Marker added";
    output.insertAdjacentElement('afterbegin', el);
}
function clearLog() {
    document.getElementById("console_log").innerHTML = "";
}
function scormLog() {
    var output = document.getElementById("console_log");
    if (output) {
        var now = new Date(), h = now.getHours(), m = now.getMinutes(), s = now.getSeconds();
        var args = Array.from(arguments);
        var label = args.shift();
        var ts = "<fieldset><legend>" + [h<10?"0"+h:h,m<10?"0"+m:m,s<10?"0"+s:s," "].join(":") + " " + label + "</legend>";
        var el = document.createElement("div");
        var args = [].map.call(args, function(argument,index) {
            return (typeof argument === 'object')
                    ? JSON.stringify(argument)
                    : typeof argument === 'undefined'
                    ? ""
                    : argument.toString();
        });
        el.innerHTML = ts + args.join("<hr>") + "</fieldset>";
        output.insertAdjacentElement('afterbegin', el);
    }
}

</script>
</head>

<body>
    <header>
        <div>
            <h1>Scorm 1.2 Tester</h1>
        </div>
        <div>
            <button onclick="console.log('simulate load');document.getElementById('scorm_object').setAttribute('src','<?php echo $source; ?>');__global__termsco__hasrun=false;return false;">Simulate load</button>
            <button onclick="console.log('simulate unload');document.getElementById('scorm_object').setAttribute('src','about:blank');setTimeout(function(){scormLog("API InternalState", API.internalState)},5000);DoRequest(null, 'unloaded', ''); return false;">Simulate unload</button>
            <button onclick="console.log('call lms commit');API.LMSCommit()">Perform LMS Commit</button>
            <button onclick="addMarker()">Add log marker</button>
            <button onclick="clearLog()">Clear Log</button>
        </div>
    </header>
    <form method="POST">
        <div>
            <p>
                <label for="suspend_data">cmi.core.suspend_data:</label><br>
                <textarea id="suspend_data" name="suspend_data" rows="4" style="width:100%"><?php echo $suspend_data; ?></textarea>
            </p>
            <p>
                <label for="core_exit">cmi.core.exit:</label><select id="core_exit" name="core_exit"><?php
                foreach ($exit_modes as $item) {
                    echo "<option value='$item' " . ($item === $core_exit ? " selected" : "") . ">$item</option>";
                } ?></select>
                <label for="lesson_status">cmi.core.lesson_status:</label><select id="lesson_status" name="lesson_status"><?php
                foreach ($statuses as $item) {
                    echo "<option value='$item' " . ($item == $lesson_status ? " selected" : "") . ">$item</option>";
                } ?></select>
                <label>cmi.core.lesson_location: <input name="lesson_location" type="number" min="0" max="999" step="1" value="<?php echo $lesson_location; ?>"></label>
                <label>cmi.core.score.raw: <input name="score_raw" type="text" size="6" placeholder="empty" value="<?php echo $score_raw; ?>"></label>
                <label>last error code: <input id="lastError" type="text" size="6" readonly></label>
                <input type="submit" value="Update SCORM data">
            </p>
        </div>
    </form>
    <main>
        <aside>
            <div id="console_log"></div>
        </aside>
        <article>
            <iframe id="scorm_object" name="scorm_frame" src="<?php echo $source; ?>" frameborder="false" allowtransparency="true" scrolling="no" seamless="seamless" onbeforeunload="API.LMSFinish()">
        </article>
    </main>
</body>
</html>