<?php
$curl = curl_init();

$city = "Dhaka"; // Set the city to Dhaka
$apiKey = "276fbc2e63msh1b5e4e7f2c9f0d5p1d363ejsn2667e56e2cb5"; // Replace with your actual API key

curl_setopt_array($curl, [
    CURLOPT_URL => "https://weatherapi-com.p.rapidapi.com/forecast.json?q=" . urlencode($city) . "&days=7",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "X-RapidAPI-Host: weatherapi-com.p.rapidapi.com",
        "X-RapidAPI-Key: " . $apiKey
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $data = json_decode($response, true);
    $currentTemperature = $data['current']['temp_c'];
    $currentDescription = $data['current']['condition']['text'];
    // Extract other data as needed
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Assuming your CSS is in a file named styles.css -->
    <title>Weather App</title>
    <style>
        
:root {
  --color-dark: #222831;
  --color-dark-light: #343d4b;
  --color-light: #fff;
  --color-primary: #c165dd;
  --color-secondary: #5c27fe;
	--color-gradient-1: linear-gradient( 135deg, #5c27fe 10%, #c165dd 100%);
	--color-gradient-2: linear-gradient( 180deg, #c165dd 10%, #5c27fe 100%);
  --box-shadow: 0 0 70px -10px rgba(0, 0, 0, 0.2);
  --spacing-base: 4px;
  --font-principal: Montserrat, sans-serif;
  --bg-image: url("https://images.unsplash.com/photo-1559963110-71b394e7494d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=675&q=80");
  --border-radius-big: 25px;
  --border-radius-small: 10px;
  --side-position: 25px;
  --transform: translateZ(0) scale(1.02) perspective(1000px);
  --transition: all 300ms ease;
}

* {
  margin: 0;
  padding: 0;
	box-sizing: border-box;
	line-height: 1.25em;
  font-family: var(--font-principal);
  list-style: none;
}

body {
	width: 100%;
	height: 100vh;
	display: flex;
  align-items: center;
  justify-content: center;
	background-color: var(--color-dark-light);
}

.c-weather {
  display: grid;
  grid-template-columns: auto;
  width: 700px;
	max-width: 80%;
	color: var(--color-light);
	background-color: var(--color-dark);
	box-shadow: var(--box-shadow);
  border-radius: var(--border-radius-big);
  overflow: hidden;
  
  @media (min-width: 768px) {
    height: 400px;
    grid-template-columns: 45% 55%;
  }
}

.c-weather__side {
  height: 100%;
	position: relative;
	border-radius: var(--border-radius-big);
	box-shadow: var(--box-shadow);
	transition: var(--transition);
	transform: var(--transform);
  
  .c-weather__side-figure {
    position: absolute;
    inset: 0;
    z-index: -1;
    
    .c-weather__side-gradient,
    .c-weather__side-image {
      position: absolute;
      inset: 0;
      border-radius: var(--border-radius-big);
    }
    
    .c-weather__side-gradient {
      background-image: var(--color-gradient-1);
      opacity: 0.8;
      z-index: 1;
    }
    
    .c-weather__side-image {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  }
  
  .c-weather__side-content {
    isolation: isolate;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: calc(var(--spacing-base) * 8);
    z-index: 1;
  }
  
  .c-weather__side-date {
    .c-weather__side-day {
      padding: var(--spacing-base) 0 calc(var(--spacing-base) * 2);
    }
  }
  
  .c-wather__side-temperature {
    .c-weather__side-temp {
      font-weight: 700;
	    font-size: 64px;
    }
  }
}

.c-weather__infos {
	position: relative;
	height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
	padding: calc(var(--spacing-base) * 8);
  
  .c-weather__today-list {
    .c-weather__today-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: calc(var(--spacing-base) * 3);
      
      &:last-child {
        margin-bottom: 0;
      }
      
      .c-weather__today-item-title {
        font-weight: 700;
        text-transform: uppercase;
      }
    }
  }
  
  .c-weather__weeklist {
    position: relative;
    flex: 1;
    display: flex;
    flex-wrap: nowrap;
    max-height: 120px;
    border-radius: var(--border-radius-small);
    
    &::before {
      content: '';
      display: block;
      position: absolute;
      inset: 0;
      background-color: var(--color-dark-light);
      border-radius: var(--border-radius-small);
      opacity: .5;
    }
    
    .c-weather__weeklist-item {
      isolation: isolate;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: calc(var(--spacing-base) * 4);
      border-radius: var(--border-radius-small);
      cursor: pointer;
      transition: var(--transition);
      
      &:hover,
      &.is-active {
        background-color: #fff;
        background-image: var(--color-gradient-2);
      }
        
      &:hover {
        transform: scale(1.1);
      }
      
      .c-weather__weeklist-item-dayname {
        padding: calc(var(--spacing-base) * 3) 0;
      }
      
      .c-weather__weeklist-item-temperature {
        font-weight: 700;
      }
    }
  }
  
  .c-weather__action {
    .c-weather__action-button {
      width: 100%;
      padding: calc(var(--spacing-base) * 5) calc(var(--spacing-base) * 3);
      outline: 0;
      border: 0;
      border-radius: var(--border-radius-big);
      color: var(--color-light);
      background-image: var(--color-gradient-1);
      font-size: 16px;
      font-weight: 700;
      text-transform: uppercase;
      cursor: pointer;
      transition: var(--transition);
      
      &:hover {
        color: var(--color-primary);
      }
    }
  }
}

    </style>
</head>

<body>

<div class="c-weather">
  <aside class="c-weather__side">
    <figure class="c-weather__side-figure">
      <img src="<?php echo $data['current']['condition']['icon']; ?>" class="c-weather__side-image">
      <div class="c-weather__side-gradient"></div>
    </figure>
    
    <div class="c-weather__side-content">
      <div class="c-weather__side-date">
        <h2 class="c-weather__side-dayname"><?php echo date('l', strtotime($data['forecast']['forecastday'][0]['date'])); ?></h2>
        <div class="c-weather__side-day"><?php echo date('d M Y', strtotime($data['forecast']['forecastday'][0]['date'])); ?></div>
        <div class="c-weather__side-location"><?php echo $data['location']['name'] . ', ' . $data['location']['country']; ?></div>
      </div>

      <div class="c-wather__side-temperature">
        <h1 class="c-weather__side-temp"><?php echo $currentTemperature; ?>°C</h1>
        <h3 class="c-weather__side-description"><?php echo $currentDescription; ?></h3>
      </div>
    </div>
  </aside>
  
  <div class="c-weather__infos">
    <ul class="c-weather__today-list">
      <!-- Update the following HTML dynamically based on API response -->
      <li class="c-weather__today-item">
        <div class="c-weather__today-item-title">Rainfall</div>
        <div class="c-weather__today-item-value"><?php echo $data['forecast']['forecastday'][0]['day']['daily_chance_of_rain']; ?>%</div>
      </li>
      
      <li class="c-weather__today-item">
        <div class="c-weather__today-item-title">Humidity</div>
        <div class="c-weather__today-item-value"><?php echo $data['current']['humidity']; ?>%</div>
      </li>
      
      <li class="c-weather__today-item">
        <div class="c-weather__today-item-title">Wind</div>
        <div class="c-weather__today-item-value"><?php echo $data['current']['wind_kph']; ?> km/h</div>
      </li>
    </ul>
    
    <ul class="c-weather__weeklist">
      <!-- Update the following HTML dynamically based on API response -->
      <?php foreach ($data['forecast']['forecastday'] as $day) : ?>
        <li class="c-weather__weeklist-item">
          <div class="c-weather__weeklist-item-dayname"><?php echo date('D', strtotime($day['date'])); ?></div>
          <div class="c-weather__weeklist-item-temperature"><?php echo $day['day']['avgtemp_c']; ?>°C</div>
        </li>
      <?php endforeach; ?>
    </ul>
    
    <div class="c-weather__action">
      <!-- <button class="c-weather__action-button">
        Cambiar localización
      </button> -->
    </div>
  </div>
</div>

</body>

</html>