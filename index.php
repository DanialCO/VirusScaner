<?php
/*
این ربات نوشته شده توسط دانیال ملک زاده(@JanPHP)و دریافت اخبار در کانال @Danial_Rbo
*/
//--@mriven
define('API_KEY','436482582:AAELKBLn4OtnDpoZtDJjLleNfz_dktV1_EY');
//--@mriven
function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//--@mriven
function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }
  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }
  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = "https://api.telegram.org/bot".API_KEY."/".$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  return exec_curl_request($handle);
}
//--@mriven
$update = json_decode(file_get_contents('php://input'));
var_dump($update);
//=========
$fromid = $update->callback_query->from->id;
$chatid = $update->callback_query->message->chat->id;
$messageid = $update->callback_query->message->message_id;
$data = $update->callback_query->data;
$chat_id = $update->message->chat->id;
$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$name = $update->message->from->first_name;
$fname = $update->message->from->last_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$txtmsg = $update->message->text;
//$fromid = $update->callback_query->from->id;
$admin = 328130490;
$reply = $update->message->reply_to_message->forward_from->id;
$stickerid = $update->message->reply_to_message->sticker->file_id;
$step = file_get_contents("data/$from_id/step.txt");
//--@mriven
function Forward($K,$Az,$Ko)
{
makereq('ForwardMessage',[
'chat_id'=>$K,
'from_chat_id'=>$Az,
'message_id'=>$Ko,
]);
}
function save($filename,$TXTdata)
 {
 $myfile = fopen($filename, "w") or die("Unable to open file!");
 fwrite($myfile, "$TXTdata");
 fclose($myfile);
 }
 function editmessage($id,$msg,$text,$key) {
 makereq('editmessagetext',[
'chat_id'=>$id,
'text'=>$text,
'message_id'=>$msg,
'reply_markup'=>$key
]);
}
 function sendmessage($id, $textm,$key)
{
 makereq('sendmessage',[
'chat_id'=>$id,
'text'=>$textm,
'reply_markup'=>$key
]);
}
//--@mriven
$d_home = json_encode([
'inline_keyboard'=>[
[
['text'=>'🔎اسکن کن🔎','callback_data'=>'scan']
],
[
['text'=>'🌀راهنمای اسکن🌀','callback_data'=>'help'],['text'=>'👤پشتیبانی👤','callback_data'=>'posh']
],
[
['text'=>'🍃درباره ما🍃','callback_data'=>'about']
],
],
'resize_keyboard'=>true,
]);
//--@mriven
$d_back = json_encode([
'inline_keyboard'=>[
[
['text'=>'🔺بازگشت🔻','callback_data'=>'back']
],
],
'resize_keyboard'=>true,
]);
//--@mriven
$d_admin = json_encode([
'inline_keyboard'=>[
[
['text'=>'🌐آمار🌐','callback_data'=>'am']
],
[
['text'=>'🌐ارسال به همه🌐','callback_data'=>'send'],['text'=>'🌐فروارد به همه🌐','callback_data'=>'for']
],
[
['text'=>'🔺بازگشت🔻','callback_data'=>'back']
],
],
'resize_keyboard'=>true,
]);
//--@mriven
$d_backadmin = json_encode([
'inline_keyboard'=>[
[
['text'=>'🍃بازگشت🍃','callback_data'=>'backadmin']
],
],
'resize_keyboard'=>true,
]);
//--@mriven
if ($textmessage == '/start') {
if (!file_exists("data/$from_id/step.txt")) {
$myfile2 = fopen("data/users.txt", 'a') or die("Unable to open file!"); 
fwrite($myfile2, "$from_id\n");
fclose($myfile2);
mkdir("data/$from_id");
sendmessage($chat_id,"😉سلام $name
به ربات ویروس اسکنر خوش آمدید
لطفا به بخش راهنما رفته و آموزش اسکن کردن فایل را یاد بگیرد
🆔سازنده: @mriven
🆔کانال ما: @DarkSkyTM😉",$d_home);
}else{
save("data/users/$from_id/step.txt","none");
sendmessage($chat_id,"😉سلام $name
به ربات ویروس اسکنر خوش آمدید
لطفا به بخش راهنما رفته و آموزش اسکن کردن فایل را یاد بگیرد
🆔سازنده: @mriven
🆔کانال ما: @DarkSkyTM😉",$d_home);
}
}
//--@mriven
if ($data == 'help') {
editmessage($chatid,$messageid,"دوست عزیز لینک‌فایل تو بفرست طبق اموزش زیر، وارد کن وقتی جواب
null
برای شما ارسال شد یعنی پاسخی دریافت نشد چند ثانیه بعد امتحان کنید

در صورت false شدن detected هیچ ویروسی در کار نیست 

در صورت true شدن detected فایل حاوی ویروس است",$d_back);
}
if ($data == 'posh') {
editmessage($chatid,$messageid,"💎این ربات نوشته شده توسط @mriven 💎
🆔: @DarkSkyTM",$d_back);
}
//--@mriven
if ($data == 'about') {
editmessage($chatid,$messageid,"🌀این ربات برای شما ساخته شده تا فایل هایی که میخواهید از اینترنت یا تلگرام و غیره دانلود کنید لینک فایل مورد نظر را برای ربات میفرستید و از سالم بودن یا نبودن فایل  مطلع می شوید🌀",$d_back);
}
//--@mriven
//--@mriven
if ($data == 'scan'){
editmessage($chatid,$messageid,"/scan LINK
خب $name لینک فایل خود را بجای LINK بزارید و برای ربات ارسال کنید",$d_back);
}
//--@mriven
if (strpos($textmessage , "/scan" ) !== false ) {
$text = str_replace("/scan ","",$textmessage);
if(preg_match('/^([Hh][Tt][Tt][Pp])/',$text)){
$mt = file_get_contents("http://danial-am.tk/scanner.php?url=$text");	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"$mt",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                 ['text'=>'🏡بازگشت🏡']
                ]
                
            	],
            	'resize_keyboard'=>true
       		])
    		]));
}else{
sendmessage($chat_id,"😕بهت گفتم لینک بفرست فازت چیه!!😕");
}
}
//--@mriven
if ($data == "back"){
save("data/$fromid/step.txt","none");
editmessage($chatid,$messageid,"به منوی اصلی برگشتیم",$d_home);
}
//--@mriven
if ($data == "backadmin"){
save("data/$fromid/step.txt","none");
editmessage($chatid,$messageid,"به منوی اصلی برگشتیم",$d_admin);
}
//--@mriven
if ($textmessage == "🏡بازگشت🏡"){
save("data/$from_id/step.txt","none");
sendmessage($chat_id,"به منوی اصلی برگشتیم",$d_admin);
}
//--@mriven
if ($textmessage == '/panel' && $from_id == $admin) {
        sendmessage($chat_id,"انتخاب کنید",$d_admin);
        }
//--@mriven
        if ($data == 'am' && $fromid == $admin) {
        $s = scandir("data");
        $c = count($s);
        editmessage($chatid,$messageid,"آمار کاربران:$c",$d_backadmin);
        }
//--@mriven
     if ($data == 'send' && $fromid == $admin) {
         save("data/$fromid/step.txt","sendd");
  editmessage($chatid,$messageid,"پیامتون رو وارد کنید.",$d_backadmin);
  }
//--@mriven
  if($step == 'sendd' and $from_id == $admin){
  save("data/$from_id/step.txt","none");
  SendMessage($chat_id,"پیام شما در صف ارسال قرار گرفت.",$d_home);
  $all = fopen( "data/users.txt", 'r');
    while( !feof( $all)) {
       $users = fgets( $all);
         sendmessage($users,"$textmessage");
      }
    }
//--@mriven
    if ($data == 'for' && $fromid == $admin) {
    save("data/$fromid/step.txt","for");
    editmessage($chatid,$messageid,"پیامتون رو فروارد کنید",$d_backadmin);
    }
    if ($step == 'for') {
    save("data/$from_id/step.txt","none");
    SendMessage($chat_id,"پیام شما در صف ارسال قرار گرفت.",$d_home);
  $all = fopen( "data/users.txt", 'r');
    while( !feof( $all)) {
       $users = fgets( $all);
         forward($users,$from_id,$message_id);
              }
    }
//--@mriven
?>
