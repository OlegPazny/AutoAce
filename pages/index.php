<?php
session_start();

require_once "../assets/api/isAdmin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <title>главная</title>
</head>

<body>
    <?php require_once "../includes/header.php"; ?>
    <section class="prons-section">
        <h2 class="prons-section__head"> мы это —</h2>
        <div class="prons-section__body">
            <div class="pron">
                <h5 class="pron__head">Преимущество 1</h5>
                <p class="pron__text">
                    Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более
                    менее.
                </p>
                <img class="pron__img" src="../assets/images/pron_arrow.png">
            </div>
            <img class="prons-section__img" src="../assets/images/wrench.png">
            <div class="bottom-prons">
                <div class="pron">
                    <img class="pron__img up" src="../assets/images/pron_arrow.png">
                    <h5 class="pron__head">Преимущество 2</h5>
                    <p class="pron__text">
                        Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более
                        менее.
                    </p>
                </div>
                <div class="pron">
                    <img class="pron__img up" src="../assets/images/pron_arrow.png">
                    <h5 class="pron__head">Преимущество 3</h5>
                    <p class="pron__text">
                        Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более
                        менее.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="about-section">
        <div class="info">
            <h2 class="info__head">об автосервисе AutoAce</h2>
            <p class="info__text">
                Сайт рыбатекст поможет дизайнеру, верстальщику, вебмастеру сгенерировать несколько абзацев более менее
                осмысленного текста рыбы на русском языке, а начинающему оратору отточить навык публичных выступлений в
                домашних условиях. При создании генератора мы использовали небезизвестный универсальный код речей. Текст
                генерируется абзацами случайным образом от двух до десяти предложений в абзаце, что позволяет сделать
                текст более привлекательным и живым для визуально-слухового восприятия.
            </p>
            <div class="button">
                <input type="button" class="button__content" value="Перейти к услугам">
            </div>
        </div>
        <div class="slider">
            <swiper-container class="mySwiper" effect="cards" grab-cursor="true">
                <swiper-slide>Slide 1</swiper-slide>
                <swiper-slide>Slide 2</swiper-slide>
                <swiper-slide>Slide 3</swiper-slide>
                <swiper-slide>Slide 4</swiper-slide>
                <swiper-slide>Slide 5</swiper-slide>
                <swiper-slide>Slide 6</swiper-slide>
                <swiper-slide>Slide 7</swiper-slide>
                <swiper-slide>Slide 8</swiper-slide>
                <swiper-slide>Slide 9</swiper-slide>
            </swiper-container>
            <img class="slider__shadow" src="../assets/images/card_shadow.png">
        </div>
    </section>
    <form action="assets/api/logout.php">
        <input type="submit" value="Выйти">
    </form>
</body>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
</html>