<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue.css">

<!-- Favicons -->
<link href="{{asset('assets/img/logo.png')}}" rel="icon">
<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<title>Kliktes</title>
<script src="https://unpkg.com/feather-icons"></script>
<style>
body {
  /* background: url("https://www.w3schools.com/howto/img_link_tree_template2_bg.jpg"); */
}

.container {
  width: 100%;
  height: 100%;
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
}

.links-container {
  display: flex;
  flex-direction: column;
  jusify-content: center;
  align-items: center;
}

.links-container a {
  width: 80%;
}

.w3-theme-l1:hover {
  background-color: #799ff2 !important;
}

.margin-top-2 {
  margin-top: 32px;
}

.bottom {
  width: 100%;
  text-align: center;
  width: auto;
  font-weight: bolder;
}

.bottom span {
  color: #4d78ed;
}

.bottom svg {
  stroke: #4d78ed;
  fill: #4d78ed;
}

@media (min-width: 768px) {
  .link {
    width: 100%;
  }
}
@media (min-width: 576px) {
  .container {
    max-width: 540px;
  }
}
</style>
  </head>
  <body>
    <!-- Content container -->
    <div class="container">

      <!-- Image and name container. Change to your pictue here. -->
      <div style="text-align: center">
        <img src="https://ui-avatars.com/api/?name={{$user->name}}&background=1F2855&color=fff" class="w3-margin" alt="image" width="150px" height="150px" style="border-radius: 50%;">
        
        <p style="font-weight: bolder;">REKOMENDASI PLATFORM TRYOUT</p>
        <p>Halo temen-temen!
          Kenalin aku {{$user->name}}, aku senang membagikan informasi terkait persiapan tes CPNS, PPPK dan Sekolah Kedinasan. Aku buatin link ini untuk memudahkan kalian mencari platform tryout yang kalian butuhkan</p>
      </div>

      <!-- Links section 1. Replace the # inside of the "" with your links. -->
      
      <div class="links-container">
        <a href="https://portal-cpns.jagotes.id/register?code={{$user->referral_code}}" class="w3-button w3-round-xlarge w3-theme-l1 w3-border link" target="_blank">CPNS</a>
        <br>
        <a href="https://portal-pppk.jagotes.id/register?code={{$user->referral_code}}" class="w3-button w3-round-xlarge w3-theme-l1 w3-border link" target="_blank">PPPK</a>
        <br>
        <a href="https://portal-kedinasan.jagotes.id/register?code={{$user->referral_code}}" class="w3-button w3-round-xlarge w3-theme-l1 w3-border link" target="_blank">SEKOLAH KEDINASAN</a>
        {{-- <br>
        <a href="https://portal-bumn.jagotes.id/register?code={{$user->referral_code}}" class="w3-button w3-round-xlarge w3-theme-l1 w3-border link" target="_blank">BUMN</a> --}}
      </div>

     

      <!-- Bottom section 3 -->
      <div class="bottom margin-top-2 w3-padding w3-round">
        <span style="vertical-align: 7px;"> 2024 - kliktes</span>
      </div>

    </div>
    <script>
      feather.replace()
    </script>
  </body>  
</html>
