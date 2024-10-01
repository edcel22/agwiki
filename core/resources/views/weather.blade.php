@extends('layouts.auth')
@section('content')
<div class="page-content">

 <!-- <form method="get">
    <div class="weather-change input-style-1">
      <input type="text" id="changeweatherlocation" name="location" placeholder="address or zip" class="form-control input-style-1" value="">
      <button type="submit" class="button button-l bg-green1-dark shadow-large button-round-small">Change Location</button>
    </div>
  </form>
-->


<script>
        (function(d, s, id) {
            if (d.getElementById(id)) {
                if (window.__TOMORROW__) {
                    window.__TOMORROW__.renderWidget();
                }
                return;
            }
            const fjs = d.getElementsByTagName(s)[0];
            const js = d.createElement(s);
            js.id = id;
            js.src = "https://www.tomorrow.io/v1/widget/sdk/sdk.bundle.min.js";

            fjs.parentNode.insertBefore(js, fjs);
        })(document, 'script', 'tomorrow-sdk');
        </script>

        <div class="tomorrow"
           data-location-id=""
           data-language="EN"
           data-unit-system="IMPERIAL"
           data-skin="light"
           data-widget-type="upcoming"
           style="padding-bottom:22px;position:relative;"
        >
          <a
            href="https://www.tomorrow.io/weather-api/"
            rel="nofollow noopener noreferrer"
            target="_blank"
            style="position: absolute; bottom: 0; transform: translateX(-50%); left: 50%;"
          >
            <img
              alt="Powered by the Tomorrow.io Weather API"
              src="https://weather-website-client.tomorrow.io/img/powered-by.svg"
              width="250"
              height="18"
            />
          </a>
        </div>



   
<!--  -->

<!-- <a class="weatherwidget-io" href="https://forecast7.com/en/autocomplete/90210/?unit=us" data-label_1="ST. LOUIS" data-label_2="WEATHER" data-theme="original" ></a>
<script>
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='https://weatherwidget.io/js/widget.min.js';fjs.parentNode.insertBefore(js,fjs);}}(document,'script','weatherwidget-io-js');
</script> -->

<!-- <div id="ww_1e868846fc31c" v='1.3' loc='id' a='{"t":"responsive","lang":"en","sl_lpl":1,"ids":[],"font":"Arial","sl_ics":"one_a","sl_sot":"fahrenheit","cl_bkg":"image","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#81D4FA","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722"}'>Weather Data Source: <a href="https://oneweather.org/los_angeles/" id="ww_1e868846fc31c_u" target="_blank">Today weather Los Angeles hourly</a></div><script async src="https://app1.weatherwidget.org/js/?id=ww_1e868846fc31c"></script> -->
 <!--

<div id="ww_f03287aa9e46f" v='1.3' loc='auto' a='{"t":"responsive","lang":"en","sl_lpl":1,"ids":[],"font":"Arial","sl_ics":"one_a","sl_sot":"fahrenheit","cl_bkg":"#1976D2","cl_font":"#FFFFFF","cl_cloud":"#FFFFFF","cl_persp":"#FFFFFF","cl_sun":"#FFC107","cl_moon":"#FFC107","cl_thund":"#FF5722","sl_tof":"7","cl_odd":"#0000000a"}'><a href="https://weatherwidget.org/android-app/" id="ww_f03287aa9e46f_u" target="_blank">Free weather app for android</a></div><script async src="https://app1.weatherwidget.org/js/?id=ww_f03287aa9e46f"></script>


    <script>
        (function(d, s, id) {
            if (d.getElementById(id)) {
                if (window.__TOMORROW__) {
                    window.__TOMORROW__.renderWidget();
                }
                return;
            }
            const fjs = d.getElementsByTagName(s)[0];
            const js = d.createElement(s);
            js.id = id;
            js.src = "https://www.tomorrow.io/v1/widget/sdk/sdk.bundle.min.js";

            fjs.parentNode.insertBefore(js, fjs);
        })(document, 'script', 'tomorrow-sdk');
        </script>

        <div class="tomorrow"
           data-location-id=""
           data-language="EN"
           data-unit-system="IMPERIAL"
           data-skin="light"
           data-widget-type="upcoming"
           style="padding-bottom:22px;position:relative;"
        >
          <a
            href="https://www.tomorrow.io/weather-api/"
            rel="nofollow noopener noreferrer"
            target="_blank"
            style="position: absolute; bottom: 0; transform: translateX(-50%); left: 50%;"
          >
            <img
              alt="Powered by the Tomorrow.io Weather API"
              src="https://weather-website-client.tomorrow.io/img/powered-by.svg"
              width="250"
              height="18"
            />
          </a>
        </div>




        


    -->



<!--
<div class="wrapper" style="padding-bottom: 20px;">
      <header><i class='bx bx-left-arrow-alt'></i>Check Your Local Weather</header>
      <section class="input-part">
        <p class="info-txt"></p>
        <div class="content">
          <input type="text" spellcheck="false" placeholder="Enter city name" required>
          <div class="separator"></div>
          <button>Get Device Location</button>
        </div>
      </section>
      <section class="weather-part">
        <img src="" alt="Weather Icon" >
        <div class="temp">
          <span class="numb">_</span>
          <span class="deg">°</span>F
        </div>
        <div class="weather">_ _</div>
        <div class="location">
          <i class='bx bx-map'></i>
          <span>_, _</span>
        </div>
        <div class="bottom-details">
          <div class="column feels">
            <i class='bx bxs-thermometer'></i>
            <div class="details">
              <div class="temp">
                <span class="numb-2">_</span>
                <span class="deg">°</span>F
              </div>
              <p>Feels like</p>
            </div>
          </div>
          <div class="column humidity">
            <i class='bx bxs-droplet-half'></i>
            <div class="details">
              <span>_</span>
              <p>Humidity</p>
            </div>
          </div>
        </div>
      </section>
    </div>
    
    

<script>
    const wrapper = document.querySelector(".wrapper"),
inputPart = document.querySelector(".input-part"),
infoTxt = inputPart.querySelector(".info-txt"),
inputField = inputPart.querySelector("input"),
locationBtn = inputPart.querySelector("button"),
weatherPart = wrapper.querySelector(".weather-part"),
wIcon = weatherPart.querySelector("img"),
arrowBack = wrapper.querySelector("header i");
let api;
inputField.addEventListener("keyup", e =>{
    if(e.key == "Enter" && inputField.value != ""){
        requestApi(inputField.value);
    }
});
locationBtn.addEventListener("click", () =>{
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(onSuccess, onError);
    }else{
        alert("Your browser not support geolocation api");
    }
});
function requestApi(city){
    api = `https://api.openweathermap.org/data/2.5/weather?q=${city}&units=imperial&appid=cda5abb7dc0b88761758ecae0d6d6e30`;
    fetchData();
}
function onSuccess(position){
    const {latitude, longitude} = position.coords;
    api = `https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&units=imperial&appid=cda5abb7dc0b88761758ecae0d6d6e30`;
    fetchData();
}
function onError(error){
    infoTxt.innerText = error.message;
    infoTxt.classList.add("error");
}
function fetchData(){
    infoTxt.innerText = "Getting weather details...";
    infoTxt.classList.add("pending");
    fetch(api).then(res => res.json()).then(result => weatherDetails(result)).catch(() =>{
        infoTxt.innerText = "Something went wrong";
        infoTxt.classList.replace("pending", "error");
    });
}
function weatherDetails(info){
    if(info.cod == "404"){
        infoTxt.classList.replace("pending", "error");
        infoTxt.innerText = `${inputField.value} isn't a valid city name`;
    }else{
        const city = info.name;
        const country = info.sys.country;
        const {description, id} = info.weather[0];
        const {temp, feels_like, humidity} = info.main;
        if(id == 800){
            wIcon.src = "/assets/front/img/icons/clear.svg";
        }else if(id >= 200 && id <= 232){
            wIcon.src = "/assets/front/img/icons/storm.svg";  
        }else if(id >= 600 && id <= 622){
            wIcon.src = "/assets/front/img/icons/snow.svg";
        }else if(id >= 701 && id <= 781){
            wIcon.src = "/assets/front/img/icons/haze.svg";
        }else if(id >= 801 && id <= 804){
            wIcon.src = "/assets/front/img/icons/cloud.svg";
        }else if((id >= 500 && id <= 531) || (id >= 300 && id <= 321)){
            wIcon.src = "/assets/front/img/icons/rain.svg";
        }
        
        weatherPart.querySelector(".temp .numb").innerText = Math.floor(temp);
        weatherPart.querySelector(".weather").innerText = description;
        weatherPart.querySelector(".location span").innerText = `${city}, ${country}`;
        weatherPart.querySelector(".temp .numb-2").innerText = Math.floor(feels_like);
        weatherPart.querySelector(".humidity span").innerText = `${humidity}%`;
        infoTxt.classList.remove("pending", "error");
        infoTxt.innerText = "";
        inputField.value = "";
        wrapper.classList.add("active");
    }
}
arrowBack.addEventListener("click", ()=>{
    wrapper.classList.remove("active");
});
</script>-->




</div> <!-- end .page-content -->
@endsection
