# Melipayamak PHP


<div dir='rtl'>

### معرفی وب سرویس ملی پیامک
ملی پیامک یک وب سرویس کامل برای ارسال و دریافت پیامک و پیامک صوتی و مدیریت کامل خدمات دیگر است که براحتی میتوانید از آن استفاده کنید.

<hr>

### نصب

<p>قبل از نصب نیاز به ثبت نام در سایت ملی پیامک دارید.</p>
<p></p>

[**ثبت نام به همراه دریافت 200 پیامک هدیه جهت تست وبسرویس**](http://www.melipayamak.com/)


<p>پس ازثبت نام  برای نصب از راههای زیر میتوانید اقدام کنید.</p>



</div>


```php
composer require melipayamak/php 
```


<div dir='rtl'>

یا از طریق اضافه کردن خط زیر به فایل 
composer.json



</div>


```json
"melipayamak/php": "*"
```


<div dir='rtl'>


و سپس اجرای دستور 



</div>

    composer update


	
<div dir='rtl'>

	
	
#### نحوه استفاده
نمونه کد برای ارسال پیامک



</div>



```php
require __DIR__ . '/vendor/autoload.php';
use Melipayamak\MelipayamakApi;
try{
    $username = 'username';
    $password = 'password';
    $api = new MelipayamakApi($username,$password);
    $sms = $api->sms();
    $to = '09123456789';
    $from = '5000...';
    $text = 'تست وب سرویس ملی پیامک';
    $response = $sms->send($to,$from,$text);
    $json = json_decode($response);
    echo $json->Value; //RecId or Error Number 
}catch(Exception $e){
    echo $e->getMessage();
}
```


<div dir='rtl'>

از آنجا که وب سرویس ملی پیامک تنها محدود به ارسال پیامک نیست  شما از طریق  زیر میتوانید به وب سرویس ها دسترسی کامل داشته باشید:


</div>

```php
// وب سرویس پیامک
$smsRest = $api->sms();
$smsSoap = $api->sms('soap');
// وب سرویس تیکت پشتیبانی
$ticket = $api->ticket();
// وب سرویس برای مدیریت کامل  ارسال انبوه پیامک
$branch = $api->branch();
//وب سرویس کاربران
$users = $api->users();
//وب سرویس دفترچه تلفن
$contacts = $api->contacts()

```

<div dir='rtl'>

##### حالت آسنکرون
شما میتوانید از وب سرویس ملی پیامک در حالت آسنکرون هم استفاده کنید. آماده سازی آسنکرون در PHP به صورت زیر است. توجه کنید که دستورات آسنکرون به شرط فراخوانی متد `execute` (بطور موازی) انجام می شوند.
	
</div>

```php
// وب سرویس پیامک
$smsRestAsync = $api->sms('async');
$smsSoapAsync = $api->sms('soap', 'async');
// وب سرویس تیکت پشتیبانی
$ticket = $api->ticket('async');
// وب سرویس برای مدیریت کامل  ارسال انبوه پیامک
$branch = $api->branch('async');
//وب سرویس کاربران
$users = $api->users('async');
//وب سرویس دفترچه تلفن
$contacts = $api->contacts('async');
```

<div dir='rtl'>


#### تفاوت های وب سرویس پیامک rest و soap
از آنجا که ملی پیامک وب سرویس کاملی رو در اختیار توسعه دهندگان میگزارد برای راحتی کار با وب سرویس پیامک علاوه بر وب سرویس اصلی soap وب سرویس rest رو هم در اختیار توسعه دهندگان گزاشته شده تا راحتتر بتوانند با وب سرویس کار کنند. تفاوت اصلی این دو در تعداد متد هاییست که میتوانید با آن کار کنید. برای کار های پایه میتوان از وب سرویس rest استفاده کرد برای دسترسی بیشتر و استفاده پیشرفته تر نیز باید از وب سرویس باید از وب سرویس soap استفاده کرد.
جهت  مطالعه بیشتر وب سرویس ها به قسمت وب سرویس پنل خود مراجعه کنید.
<hr/>

###  اطلاعات بیشتر

برای مطالعه بیشتر و دریافت راهنمای وب سرویس ها و آشنایی با پارامتر های ورودی و خروجی وب سرویس به صفحه معرفی
[وب سرویس ملی پیامک](https://github.com/Melipayamak/Webservices)
مراجعه نمایید .

<hr/>


### وب سرویس پیامک

متد های وب سرویس:


</div>

#### ارسال

```php
$smsRest->send($to,$from,$text,$isFlash);
$smsSoap->send($to,$from,$text,$isFlash);
```

#### ارسال از خط خدماتی اشتراکی

```php
$smsRest->sendByBaseNumber($text,$to,$bodyId);
$smsSoap->sendByBaseNumber($text,$to,$bodyId);
```

* در وب سرویس soap به جای ارسال یک شماره آرایه ای از شماره ها نیز قابل قبول است

#### دریافت وضعیت ارسال
```php
$smsRest->isDelivered($recId);
$smsSoap->isDelivered($recId);
```
* به در وب سرویس soap به جای تک آیدی میتوان آرایه نیز ارسال کرد.
#### لیست پیامک ها
```php
$smsRest->getMessages($location,$index,$count,$from);
$smsSoap->getMessages($location,$index,$count,$from);
$smsSoap->getMessagesStr($location,$index,$count,$from);
// جهت دریافت به صورت رشته ای
$smsSoap->getMessagesByDate($location,$index,$count,$from,$dateFrom,$dateTo);
//جهت دریافت بر اساس تاریخ
$smsSoap->getUsersMessagesByDate($location,$index,$count,$from,$dateFrom,$dateTo);
// جهت دریافت پیام های کاربران بر اساس تاریخ 
```

#### موجودی
```php
$smsRest->getCredit();
$smsSoap->getCredit();
```

#### تعرفه پایه / دریافت قیمت قبل از ارسال
```php
$smsRest->getBasePrice();
$smsSoap->getPrice($irancellCount,$mtnCount,$from,$text);
```
#### لیست شماره اختصاصی
```php
$smsRest->getNumbers();
```

#### بررسی تعداد پیامک های دریافتی
```php
$smsSoap->getInboxCount($isRead);
//پیش فرض خوانده نشده 
```

#### ارسال پیامک پیشرفته
```php
$smsSoap->send2($to,$from,$text,$isflash,$udh);
```

#### مشاهده مشخصات پیام
```php
$smsSoap->getMessagesReceptions($msgId,$fromRows);
```


#### حذف پیام دریافتی
```php
$smsSoap->remove($msgIds);
```


#### ارسال زماندار
```php
$smsSoap->sendSchedule($to,$from,$text,$isflash,$scheduleDateTime,$period);
```

#### ارسال زماندار متناظر
```php
$smsSoap->sendMultipleSchedule($to,$from,$text,$isflash,$scheduleDateTime,$period);
```


#### ارسال سررسید
```php
$smsSoap->addUsance($to,$from,$text,$isflash,$scheduleStartDateTime,$repeatAfterDays,$scheduleEndDateTime);
```

#### مشاهده وضعیت ارسال زماندار
```php
$smsSoap->getScheduleStatus($schId);
```

#### حذف پیامک زماندار
```php
$smsSoap->removeSchedule($schId);
```

### وب سرویس پیامک صوتی

####  ارسال پیامک همراه با تماس صوتی
```php
$smsSoap->sendWithSpeech($to,$from,$text,$speech);
```

####  ارسال پیامک همراه با تماس صوتی به صورت زمانبندی
```php
$smsSoap->sendWithSpeechSchduleDate($to,$from,$text,$speech,$scheduleDate);
```

####  دریافت وضعیت پیامک همراه با تماس صوتی 
```php
$smsSoap->getSendWithSpeech($recId);
```

#### تماس انبوه زماندار
```php
$smsSoap->SendBulkSpeechText($title, $body, $receivers, $DateToSend, $repeatCount);
```

#### تماس انبوه زماندار با انتخاب فایل
```php
$smsSoap->SendBulkVoiceSMS($title, $voiceFileId, $receivers, $DateToSend, $repeatCount);
```

#### آپلود فایل صوتی
```php
$smsSoap->UploadVoiceFile($title, $base64StringFile);
```

### وب سرویس ارسال انبوه/منطقه ای

#### دریافت شناسه شاخه های بانک شماره
```php
$branch->get($owner);
```


#### اضافه کردن یک بانک شماره جدید
```php
$branch->add($branchName,$owner);
```

#### اضافه کردن شماره به بانک
```php
$branch->addNumber($mobileNumbers,$branchId);
```

#### حذف یک بانک
```php
$branch->remove($branchId);
```

#### ارسال انبوه از طریق بانک
```php
$branch->sendBulk($from,$title,$message,$branch,$DateToSend,$requestCount,$bulkType,$rowFrom,$rangeFrom,$rangeTo);
$branch->sendBulk2($from,$title,$message,$branch,$DateToSend,$requestCount,$bulkType,$rowFrom,$rangeFrom,$rangeTo);
```

#### تعداد شماره های موجود
```php
$branch->getBulkCount($branch,$rangeFrom,$rangeTo);
```

#### گزارش گیری از ارسال انبوه
```php
$branch->getBulkReceptions($bulkId,$fromRows);
```


#### تعیین وضعیت ارسال 
```php
$branch->getBulkStatus($bulkId);
```

#### تعداد ارسال های امروز
```php
$branch->getTodaySent();
```

#### تعداد ارسال های کل

```php
$branch->getTotalSent();
```

#### حذف ارسال منطقه ای
```php
$branch->removeBulk($id);
```

#### ارسال متناظر
```php
$branch->sendMultipleSms($to,$from,$text,$isflash,$udh);
```

#### نمایش دهنده وضعیت گزارش گیری

```php
$branch->updateBulkDelivery($bulkId);
```
### وب سرویس تیکت

#### ثبت تیکت جدید
```php
$ticket->add($title,$content,$aletWithSms);
```

#### جستجو و دریافت تیکت ها

```php
$ticket->getReceived($ticketOwner,$ticketType,$keyword);
```

#### دریافت تعداد تیکت های کاربران
```php
$ticket->getReceivedCount($ticketType);
```

#### دریافت تیکت های ارسال شده
```php
$ticket->getSent($ticketOwner,$ticketType,$keyword);
```

#### دریافت تعداد تیکت های ارسال شده
```php
$ticket->getSentCount($ticketType);
```


#### پاسخگویی به تیکت
```php
$ticket->response($ticketId,$type,$content,$alertWithSms);
```

### وب سرویس دفترچه تلفن

#### اضافه کردن گروه جدید
```php
$contacts->addGroup($groupName,$Descriptions,$showToChilds);
```

#### اضافه کردن کاربر جدید
```php
$contacts->add($options);

```

#### بررسی موجود بودن شماره در دفترچه تلفن
```php
$contacts->checkMobileExist($mobileNumber);
```

#### دریافت اطلاعات دفترچه تلفن
```php
$contacts->get($groupId,$keyword,$from,$count);
```
#### دریافت گروه ها
```php
$contacts->getGroups();
```
#### ویرایش مخاطب
```php
$contacts->change($options);
```

#### حذف مخاطب
```php
$contacts->remove($mobilenumber);
```
#### دریافت اطلاعات مناسبت های فرد
```php
$contacts->getEvents($contactId);
```



### وب سرویس کاربران

#### ثبت فیش واریزی
```php
$users->addPayment($options);
```

#### اضافه کردن کاربر جدید در سامانه
```php
$users->add($options);

```

#### اضافه کردن کاربر جدید در سامانه(کامل)
```php
$users->addComplete($options);
```

#### اضافه کردن کاربر جدید در سامانه(WithLocation)
```php
$users->addWithLocation($options);
```
#### بدست آوردن ID کاربر
```php
$users->authenticate();
```
#### تغییر اعتبار
```php
$users->changeCredit($amount,$description,$targetUsername,$GetTax);
```

#### فراموشی رمز عبور
```php
$users->forgotPassword($mobileNumber,$emailAddress,$targetUsername);
```
#### دریافت تعرفه پایه کاربر
```php
$users->getBasePrice($targetUsername);
```

#### دریافت اعتبار کاربر
```php
$users->getCredit($targetUsername);
```

#### دریافت مشخصات کاربر
```php
$users->getDetails($targetUsername);
```

#### دریافت شماره های کاربر
```php
$users->getNumbers();
```

#### دریافت تراکنش های کاربر
```php
$users->getTransactions($targetUsername,$creditType,$dateFrom,$dateTo,$keyword);
```

#### دریافت اطلاعات  کاربران
```php
$users->get();
```


#### دریافت اطلاعات  فیلترینگ
```php
$users->hasFilter($text);
```


####  حذف کاربر
```php
$users->remove($targetUsername);
```


#### مشاهده استان ها
```php
$users->getProvinces();
```

#### مشاهده کد شهرستان 
```php
$users->getCities($provinceId);
```


#### مشاهده تاریخ انقضای کاربر 
```php
$users->getExpireDate();
```
