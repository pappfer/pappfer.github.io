<?php
/**
 * Returns the valid languages. The language code (ISO 639-1) is the array key.
 * @return array
 */
function validLangs()
{
    return [
        'de' => 'de_DE.utf8',
        'en' => 'en_GB.utf8',
        'hu' => 'hu_HU.utf8',
    ];
}

function assetPath($filename, $type = 'css')
{
    $manifestPath = './build/rev-manifest.json';

    if (file_exists($manifestPath)) {
        $manifest = json_decode(file_get_contents($manifestPath), TRUE);
    } else {
        $manifest = [];
    }

    if (array_key_exists($filename, $manifest)) {
        return './build/' . $type . '/' . $manifest[$filename];
    }

    return $filename;
}

/**
 * Verifies if the given $locale is supported in the project.
 * @param string $locale
 * @return bool
 */
function valid($locale)
{
    return array_key_exists($locale, validLangs());
}

$lang = 'en';
$root = './';
$url = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]";
$title = _('Freelancer PHP/Yii2/JavaScript/React developer');
$description = _('Experienced freelancer full stack developer. PHP/Yii2/JavaScript/VueJS expert, Laravel, Symfony skills, fluent English, advanced Linux knowledge.');

if (strlen($_SERVER['REQUEST_URI']) > 2 && valid($_SERVER['REQUEST_URI'][1] . $_SERVER['REQUEST_URI'][2])) {
    $lang = $_SERVER['REQUEST_URI'][1] . $_SERVER['REQUEST_URI'][2];
    setcookie('lang', $lang);
} else if (isset($_GET['lang']) && valid($_GET['lang'])) {
    $lang = htmlspecialchars($_GET['lang']);
    setcookie('lang', $lang);
} else if (isset($_COOKIE['lang']) && valid($_COOKIE['lang'])) {
    $lang = htmlspecialchars($_COOKIE['lang']);
} else if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $languages = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
    array_walk($languages, static function (&$lang) {
        $lang = strtr(strtok($lang, ';'), ['-' => '_']);
    });
    foreach ($languages as $browserLang) {
        if (valid($browserLang)) {
            $lang = $browserLang;
            break;
        }
    }
}

putenv('LANG=' . validLangs()[$lang]);
setlocale(LC_ALL, validLangs()[$lang]);
bindtextdomain('app', './locales');
bind_textdomain_codeset('app', 'UTF-8');
textdomain('app');

$testimonials = [
    [
        'name' => 'Phil Guegan',
        'title' => 'CEO & Founder - Infogems',
        'speech' => _('Excellent freelancer and very easy to work with. Great knowledge of Yii/PHP, excellent English and very good communicator, and very reliable.'),
    ],
    [
        'name' => 'webtechriders',
        'title' => '',
        'speech' => _('Ferenc is the best contractor that I met ever on Elance. He is highly talented, professional and hard worker. He did the task exactly I ask him to do. Ferenc completed the task and made sure I was completely satisfied. He was very responsive to questions and concerns. I will indeed be a repeat customer as I am very pleased with my website!'),
    ],
    [
        'name' => 'DanD',
        'title' => '',
        'speech' => _('Ferenc is a very talented PHP developer. He quickly got to grips with what was required and delivered everything (and more) that I expected of him. I would happily work with him again.'),
    ],
    [
        'name' => 'kall52',
        'title' => '',
        'speech' => _('I would most definitely re-hire pappfer and I highly recommend his services.'),
    ],
];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>" class="theme-color-07cb79 theme-skin-light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $title ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= $root ?>favicon.ico">
    <?php foreach (array_keys(validLangs()) as $langItem) {
        if ($lang === $langItem) {
            continue;
        }
        echo '<link rel="alternate" hreflang="' . $langItem . '" href="' . $url . '/' . $langItem . '">';
        echo "\n\t";
    } ?>

    <!-- SEO -->
    <meta name="description" content="<?= $description ?>">
    <meta property="og:locale" content="<?= !empty(validLangs()[$lang]) ? validLangs()[$lang] : $lang ?>"/>
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $title ?>"/>
    <meta property="og:description" content="<?= $description ?>">
    <meta property="og:url" content="<?= $url . '/' . $lang ?>">
    <meta property="og:site_name" content="pappfer.hu">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= $title ?>">
    <meta name="twitter:description" content="<?= $description ?>">
    <meta name="twitter:site" content="@pappfer">

    <link rel="stylesheet" type="text/css" href="<?= assetPath('bundle.css', 'css') ?>">
</head>

<body class="home header-has-img loading">

<div class="mobile-nav">
    <button class="btn-mobile mobile-nav-close"><i class="rsicon rsicon-close"></i></button>

    <div class="mobile-nav-inner">
        <nav id="mobile-nav" class="nav">
            <ul class="clearfix">
                <li><a href="#about"><?= _('About') ?></a></li>
                <li><a href="#skills"><?= _('Skills') ?></a></li>
                <!--<li><a href="#portfolio"><?= _('Portfolio') ?></a></li>-->
                <li><a href="#experience"><?= _('Experience') ?></a></li>
                <li><a href="#references"><?= _('References') ?></a></li>
                <li><a href="#blog"><?= _('Blog') ?></a></li>
                <li><a href="#contact"><?= _('Contact') ?></a></li>
            </ul>
        </nav>
    </div>
</div>
<!-- .mobile-nav -->

<div class="sidebar sidebar-fixed">
    <button class="btn-sidebar btn-sidebar-close"><i class="rsicon rsicon-close"></i></button>

    <div class="widget-area">
        <aside class="widget widget-profile">
            <div class="profile-photo">
                <img src="<?= $root ?>img/uploads/pappfer.jpg" alt="<?= _('Ferenc Papp') ?>">
            </div>
            <div class="profile-info">
                <h2 class="profile-title"><?= _('Ferenc Papp') ?></h2>

                <h3 class="profile-position"><?= _('Full stack web developer') ?></h3>
            </div>
        </aside>
        <!-- .widget-profile -->

        <aside class="widget widget_search">
            <h2 class="widget-title"><?= _('Search') ?></h2>

            <form class="search-form">
                <label class="ripple">
                    <span class="screen-reader-text"><?= _('Search for:') ?></span>
                    <input class="search-field" type="search" placeholder="<?= _('Search') ?>">
                </label>
                <input type="submit" class="search-submit" value="<?= _('Search') ?>">
            </form>
        </aside>
        <!-- .widget_search -->

        <aside class="widget widget_contact">
            <h2 class="widget-title"><?= _('Contact me') ?></h2>

            <form class="rsForm" action="/php/mailsender.php" method="post">
                <div class="input-field">
                    <label for="mobile-contact-name"><?= _('Name') ?></label>
                    <input id="mobile-contact-name" type="text" name="rsName" value="">
                    <span class="line"></span>
                </div>

                <div class="input-field">
                    <label for="mobile-contact-email"><?= _('Email') ?></label>
                    <input id="mobile-contact-email" type="email" name="rsEmail" value="">
                    <span class="line"></span>
                </div>

                <div class="input-field">
                    <label for="mobile-contact-subject"><?= _('Subject') ?></label>
                    <input id="mobile-contact-subject" type="text" name="rsSubject" value="">
                    <span class="line"></span>
                </div>

                <div class="input-field">
                    <label for="mobile-contact-message"><?= _('Message') ?></label>
                    <textarea id="mobile-contact-message" rows="4" name="rsMessage"></textarea>
                    <span class="line"></span>
                </div>

                <br>

                <span class="btn-outer btn-primary-outer ripple">
                        <input class="rsFormSubmit btn btn-lg btn-primary" type="submit" value="<?= _('Send') ?>">
                    </span>
            </form>
        </aside>
        <!-- .widget_contact -->
    </div>
    <!-- .widget-area -->
</div>
<!-- .sidebar -->

<div class="wrapper">
    <header class="header">
        <div class="head-bg" style="background-image: url('<?= $root ?>img/uploads/mac-coffee-optimized.jpg')"></div>

        <div class="head-bar">
            <div class="head-bar-inner">
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <a class="logo" href="<?= $url . '/' . $lang ?>"><span>papp</span>fer</a>
                    </div>

                    <div class="col-sm-9 col-xs-6">
                        <div class="nav-wrap">
                            <nav id="nav" class="nav">
                                <ul class="clearfix">
                                    <li><a href="#about"><?= _('About') ?></a></li>
                                    <li><a href="#skills"><?= _('Skills') ?></a></li>
                                    <!--<li><a href="#portfolio"><?= _('Portfolio') ?></a></li>-->
                                    <li><a href="#experience"><?= _('Experience') ?></a></li>
                                    <li><a href="#references"><?= _('References') ?></a></li>
                                    <li><a href="#blog"><?= _('Blog') ?></a></li>
                                    <li><a href="#contact"><?= _('Contact') ?></a></li>
                                    <li>
                                        <a href="<?= $url . '/' . 'en' ?>">
                                            <img src="<?= $root ?>img/en.png" alt="<?= _('English') ?>">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= $url . '/' . 'hu' ?>">
                                            <img src="<?= $root ?>img/hu.png" alt="<?= _('Hungarian') ?>">
                                        </a>
                                    </li>
                                </ul>
                            </nav>

                            <button class="btn-mobile btn-mobile-nav"><?= _('Menu') ?></button>
                            <button class="btn-sidebar btn-sidebar-open"><i class="rsicon rsicon-menu"></i></button>
                        </div>
                        <!-- .nav-wrap -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- .header -->

    <div class="content">
        <div class="container">

            <!-- START: PAGE CONTENT -->
            <section id="about" class="section section-about">
                <div class="animate-up">
                    <div class="section-box">
                        <div class="profile">
                            <div class="row">
                                <div class="col-xs-5">
                                    <div class="profile-photo">
                                        <img src="<?= $root ?>img/uploads/pappfer.jpg" alt="<?= _('Ferenc Papp') ?>">
                                    </div>
                                </div>
                                <div class="col-xs-7">
                                    <div class="profile-info">
                                        <div class="profile-preword"><span><?= _('Hello') ?></span></div>
                                        <h1 class="profile-title"><?= _('<span>I\'m</span> Ferenc Papp') ?></h1>

                                        <h2 class="profile-position"><?= _('Full stack web developer') ?></h2></div>
                                    <ul class="profile-list">
                                        <li class="clearfix">
                                            <strong class="title"><?= _('Age') ?></strong>
                                            <span class="cont">33</span>
                                        </li>
                                        <li class="clearfix">
                                            <strong class="title"><?= _('Address') ?></strong>
                                            <span class="cont"><?= _('Debrecen, Hungary, 4032') ?></span>
                                        </li>
                                        <li class="clearfix">
                                            <strong class="title"><?= _('Email') ?></strong>
                                            <span class="cont">
                                                <a href="mailto:pappfer@pappfer.hu">pappfer@pappfer.hu</a>
                                            </span>
                                        </li>
                                        <li class="clearfix">
                                            <strong class="title">LinkedIn</strong>
                                            <span class="cont">
                                                <a href="https://www.linkedin.com/in/pappfer">linkedin.com/in/pappfer</a>
                                            </span>
                                        </li>
                                        <!--<li class="clearfix">
                                            <span class="button" style="background: #d9534f">
                                                <?= _('Currently unavailable for new projects') ?>
                                            </span>
                                        </li>-->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="profile-social">
                            <ul class="social">
                                <li>
                                    <a class="ripple-centered" href="https://twitter.com/pappfer" target="_blank">
                                        <i class="rsicon rsicon-twitter"></i>
                                    </a>
                                </li>
                                <li><a class="ripple-centered" href="https://www.linkedin.com/in/pappfer"
                                       target="_blank"><i
                                                class="rsicon rsicon-linkedin"></i></a></li>
                                <li><a class="ripple-centered" href="https://github.com/pappfer" target="_blank"><i
                                                class="rsicon rsicon-github"></i></a></li>
                                <li><a class="ripple-centered" href="https://stackoverflow.com/users/3736962/pappfer"
                                       target="_blank"><i
                                                class="rsicon rsicon-stack-overflow"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="section-txt-btn">
                        <p><a class="btn btn-lg btn-border ripple" target="_blank"
                              href="<?= $root ?>resume.json"><?= _('Download Resume') ?></a></p>

                        <p><?= _('I\'m a professional full stack web developer with 10+ years of experience.') ?>
                            <?= _('I develop backend projects in PHP, using Laravel, Symfony or Yii2 framework and prefer to code frontend in either VueJS or React JS.') ?>
                            <?= _('I have advanced HTML, CSS and even SEO skills, decent Linux knowledge, and experience with using Amazon AWS.') ?>
                            <?= _('My job is also my passion, I truly enjoy following best practices, keeping up with new technologies and trends.') ?>
                            <?= _('I am reliable and demanding for my work but I\'m not doing well under stress.') ?>
                            <?= _('I speak English fluently.') ?>
                        </p>
                    </div>
                </div>
            </section>
            <!-- #about -->

            <section id="skills" class="section section-skills">
                <div class="animate-up">
                    <h2 class="section-title"><?= _('Professional Skills') ?></h2>

                    <div class="section-box">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="progress-bar">
                                    <div class="bar-data">
                                        <span class="bar-title">PHP & MySQL</span>
                                        <span class="bar-value">89%</span>
                                    </div>
                                    <div class="bar-line">
                                        <span class="bar-fill" data-width="89%"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="progress-bar">
                                    <div class="bar-data">
                                        <span class="bar-title">Yii2 framework / Laravel</span>
                                        <span class="bar-value">85%</span>
                                    </div>
                                    <div class="bar-line">
                                        <span class="bar-fill" data-width="85%"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="progress-bar">
                                    <div class="bar-data">
                                        <span class="bar-title">JavaScript</span>
                                        <span class="bar-value">80%</span>
                                    </div>
                                    <div class="bar-line">
                                        <span class="bar-fill" data-width="80%"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="progress-bar">
                                    <div class="bar-data">
                                        <span class="bar-title">HTML & CSS</span>
                                        <span class="bar-value">89%</span>
                                    </div>
                                    <div class="bar-line">
                                        <span class="bar-fill" data-width="89%"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="progress-bar">
                                    <div class="bar-data">
                                        <span class="bar-title">Wordpress, Symfony</span>
                                        <span class="bar-value">75%</span>
                                    </div>
                                    <div class="bar-line">
                                        <span class="bar-fill" data-width="75%"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="progress-bar">
                                    <div class="bar-data">
                                        <span class="bar-title">Phonegap / Cordova</span>
                                        <span class="bar-value">70%</span>
                                    </div>
                                    <div class="bar-line">
                                        <span class="bar-fill" data-width="70%"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="progress-bar">
                                    <div class="bar-data">
                                        <span class="bar-title">React, Vue.js, AngularJS</span>
                                        <span class="bar-value">70%</span>
                                    </div>
                                    <div class="bar-line">
                                        <span class="bar-fill" data-width="70%"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="progress-bar">
                                    <div class="bar-data">
                                        <span class="bar-title">React Native, Ionic Framework</span>
                                        <span class="bar-value">60%</span>
                                    </div>
                                    <div class="bar-line">
                                        <span class="bar-fill" data-width="60%"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- #skills -->

            <section id="experience" class="section section-experience">
                <div class="animate-up">
                    <h2 class="section-title"><?= _('Work Experience') ?></h2>

                    <div class="timeline">
                        <div class="timeline-bar"></div>
                        <div class="timeline-inner clearfix">
                            <div class="timeline-box timeline-box-right">
                                <span class="dot"></span>

                                <div class="timeline-box-inner animate-left">
                                    <span class="arrow"></span>

                                    <div class="date">2017 - <?= _('present') ?></div>
                                    <h3><?= _('Contractor') ?></h3>
                                    <h4><?= _('Full stack web developer') ?></h4>

                                    <p><?= _('I am currently an entrepreneur working as a full stack web developer.') ?></p>
                                </div>
                            </div>

                            <div class="timeline-box timeline-box-left">
                                <span class="dot"></span>

                                <div class="timeline-box-inner animate-right">
                                    <span class="arrow"></span>

                                    <div class="date">2015 - 2017</div>
                                    <h3>Fathom Minds</h3>
                                    <h4><?= _('Senior PHP developer') ?></h4>

                                    <p><?= _('I was working at Fathom Minds as a senior developer. I mainly used Yii2 framework 
                                    for developing websites, web APIs but I also had the chance to set up the company\'s Git environment
                                    and work on our own Flow project.') ?></p>
                                </div>
                            </div>

                            <div class="timeline-box timeline-box-right">
                                <span class="dot"></span>

                                <div class="timeline-box-inner animate-left">
                                    <span class="arrow"></span>

                                    <div class="date">2014 - 2015</div>
                                    <h3><?= _('Oktafone') ?></h3>
                                    <h4><?= _('Frontend developer') ?></h4>

                                    <p><?= _('I was working on a web application for a startup company. I used AngularJS, 
                                    JavaScript, HTML5 and CSS3 technologies.') ?></p>
                                </div>
                            </div>

                            <div class="timeline-box timeline-box-left">
                                <span class="dot"></span>

                                <div class="timeline-box-inner animate-right">
                                    <span class="arrow"></span>

                                    <div class="date">2012 - 2014</div>
                                    <h3>pappfer.hu</h3>
                                    <h4><?= _('Freelancer PHP developer') ?></h4>

                                    <p><?= _('I developed websites for both individuals and companies. I get most of my work 
                                    through freelancer websites. I prefer to use Yii framework for new projects but I also 
                                    had to use plain PHP or other frameworks. Used technologies:') ?></p>
                                    <ul>
                                        <li>PHP, Yii framework, Wordpress, Laravel</li>
                                        <li>HTML5, CSS3, JavaScript, jQuery, AngularJS</li>
                                        <li>Twitter Bootstrap, Zurb Foundation</li>
                                        <li>Facebook, LinkedIn, Box.com, Stripe integration</li>
                                        <li>Yii console application (scheduled e-mails with cronjob)</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="timeline-box timeline-box-right">
                                <span class="dot"></span>

                                <div class="timeline-box-inner animate-left">
                                    <span class="arrow"></span>

                                    <div class="date">2011 - 2012</div>
                                    <h3>British Telecom</h3>
                                    <h4><?= _('Network administrator') ?></h4>

                                    <p><?= _('I was configuring network tools such as routers, switches. We supported many 
                                    networks all over the world. I spoke English with customers all over the world and also 
                                    achieved soft skill certificates.') ?></p>
                                </div>
                            </div>

                            <div class="timeline-box timeline-box-left">
                                <span class="dot"></span>

                                <div class="timeline-box-inner animate-right">
                                    <span class="arrow"></span>

                                    <div class="date">2010 - 2011</div>
                                    <h3>IT Services</h3>
                                    <h4><?= _('System administrator') ?></h4>

                                    <p><?= _('I was maintaining Linux and Windows servers and I was also administering 
                                    Avaya IP phones. During my working hours I had a possibility to develop PHP application 
                                    as well. With one of my mates we created a PHP script which automated many monotonous task. 
                                    With the result of this we saved about 3 hours a day for all of my colleagues. 
                                    Later I got great recognition for this job. Apart from this we also created a 
                                    Greasemonkey script to make our colleagues life easier.') ?></p>
                                    <ul>
                                        <li><?= _('IT Services innovation award for the PHP script what me and my mate has created') ?></li>
                                        <li><?= _('Learning German (basic level)') ?></li>
                                        <li><?= _('Soft skill certificates') ?></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="timeline-box timeline-box-right">
                                <span class="dot"></span>

                                <div class="timeline-box-inner animate-left">
                                    <span class="arrow"></span>

                                    <div class="date">2009 - 2010</div>
                                    <h3>Concept Solutions</h3>
                                    <h4><?= _('PHP developer') ?></h4>

                                    <p><?= _('I was doing remote work. We used PHP. Most of the times I had to continue 
                                    or fix someone else’s code so I had a chance to see many different source code and 
                                    I gained lots of experience.') ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- #experience -->

            <section id="education" class="section section-education">
                <div class="animate-up">
                    <h2 class="section-title"><?= _('Education & Charity') ?></h2>

                    <div class="timeline">
                        <div class="timeline-bar"></div>
                        <div class="timeline-inner clearfix">

                            <div class="timeline-box timeline-box-compact timeline-box-left">
                                <span class="dot"></span>

                                <div class="timeline-box-inner animate-right">
                                    <span class="arrow"></span>

                                    <div class="date"><span>2005 - <?= _('(unfinished)') ?></span></div>
                                    <h3><?= _('Software Engineering') ?></h3>
                                    <h4><?= _('University of Debrecen') ?></h4>
                                </div>
                            </div>

                            <div class="timeline-box timeline-box-compact timeline-box-left">
                                <span class="dot"></span>

                                <div class="timeline-box-inner animate-right">
                                    <span class="arrow"></span>

                                    <div class="date"><span>2004 - 2005</span></div>
                                    <h3><?= _('Worked in a charity shop in Edinburgh, Scotland') ?></h3>
                                    <h4>Bethany Christian Trust</h4>
                                </div>
                            </div>

                            <div class="timeline-box timeline-box-compact timeline-box-right">
                                <span class="dot"></span>

                                <div class="timeline-box-inner animate-left">
                                    <span class="arrow"></span>

                                    <div class="date"><span>2000 - 2004</span></div>
                                    <h3><?= _('IT specialist') ?></h3>
                                    <h4><?= _('Reformed College of Debrecen') ?></h4>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!-- #education -->

            <section id="clients" class="section section-clients">
                <div class="animate-up">

                    <div class="clients-carousel">
                        <div class="client-logo">
                            <img src="<?= $root ?>img/uploads/logos/logo-yii.png" title="Yii2 framework"
                                 alt="Yii2 framework">
                        </div>

                        <div class="client-logo">
                            <img src="<?= $root ?>img/uploads/logos/logo-vuejs.png" title="Vue JS"
                                 alt="Vue JS">
                        </div>

                        <div class="client-logo">
                            <img src="<?= $root ?>img/uploads/logos/logo-wordpress.png" title="Wordpress"
                                 alt="Wordpress">
                        </div>

                        <div class="client-logo">
                            <img src="<?= $root ?>img/uploads/logos/logo-bootstrap.png" title="Bootstrap"
                                 alt="bootstrap">
                        </div>

                        <div class="client-logo">
                            <img src="<?= $root ?>img/uploads/logos/logo-jquery.png" title="jQuery" alt="jQuery">
                        </div>
                    </div>
                </div>
            </section>
            <!-- #clients -->

            <section id="references" class="section section-references">
                <div class="animate-up">
                    <h2 class="section-title"><?= _('References') ?></h2>

                    <div class="section-box">
                        <ul class="ref-slider">
                            <?php foreach ($testimonials as $testimonial) : ?>
                                <li>
                                    <div class="ref-box">
                                        <div class="person-speech">
                                            <p><?= $testimonial['speech'] ?></p>
                                        </div>
                                        <div class="person-info clearfix">
                                            <div class="person-name-title">
                                                <span class="person-name"><i
                                                            class="rsicon rsicon-user"></i> <?= $testimonial['name'] ?></span>
                                                <?php if (!empty($testimonial['title'])) { ?>
                                                    <span class="person-title"><?= $testimonial['title'] ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="ref-slider-nav">
                            <span id="ref-slider-prev" class="slider-prev"></span>
                            <span id="ref-slider-next" class="slider-next"></span>
                        </div>
                    </div>
                </div>
            </section>
            <!-- #references -->

            <!--<section id="text-section" class="section section-text">
                <div class="animate-up animated">
                    <h2 class="section-title">Text Section</h2>

                    <div class="section-box">
                        <p>More about me...</p>
                    </div>
                </div>
            </section>-->
            <!-- #text-section -->

            <section id="interests" class="section section-interests">
                <div class="animate-up">
                    <h2 class="section-title"><?= _('My Interests') ?></h2>

                    <div class="section-box">
                        <p><?= _('My favourite hobby is playing football but I really like any kind of sports. I like hiking,
                        cycling, swimming, playing squash, table tennis and bowling.') ?></p>

                        <ul class="interests-list">
                            <li>
                                <i class="map-icon map-icon-bicycling"></i>
                                <span><?= ('Bicycling') ?></span>
                            </li>
                            <li>
                                <i class="map-icon map-icon-swimming"></i>
                                <span><?= ('Swimming') ?></span>
                            </li>
                            <li>
                                <i class="map-icon map-icon-horse-riding"></i>
                                <span><?= ('Horse riding') ?></span>
                            </li>
                            <li>
                                <i class="map-icon map-icon-bowling-alley"></i>
                                <span><?= ('Playing Bowling') ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- #interests -->

            <section id="blog" class="section section-interests">
                <div class="animate-up">
                    <h2 class="section-title"><?= _('Blog') ?></h2>

                    <div class="section-box">
                        <a class="twitter-timeline" data-height="600" data-dnt="true" data-theme="light"
                           data-link-color="#19CF86" href="https://twitter.com/pappfer?ref_src=twsrc%5Etfw">Tweets by
                            pappfer</a>
                        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                    </div>
                </div>
            </section>
            <!-- #blog -->

            <section id="contact" class="section section-contact">
                <div class="animate-up">
                    <h2 class="section-title"><?= _('Contact Me') ?></h2>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="section-box contact-form">
                                <h3><?= _('Feel free to contact me') ?></h3>

                                <form class="rsForm" action="php/mailsender.php" method="post">
                                    <div class="input-field">
                                        <label for="contact-name"><?= _('Name') ?></label>
                                        <input id="contact-name" type="text" name="rsName" value="">
                                        <span class="line"></span>
                                    </div>

                                    <div class="input-field">
                                        <label for="contact-email"><?= _('Email') ?></label>
                                        <input id="contact-email" type="email" name="rsEmail" value="">
                                        <span class="line"></span>
                                    </div>

                                    <div class="input-field">
                                        <label for="contact-subject"><?= _('Subject') ?></label>
                                        <input id="contact-subject" type="text" name="rsSubject" value="">
                                        <span class="line"></span>
                                    </div>

                                    <div class="input-field">
                                        <label for="contact-message"><?= _('Message') ?></label>
                                        <textarea id="contact-message" rows="4" name="rsMessage"></textarea>
                                        <span class="line"></span>
                                    </div>

                                    <span class="btn-outer btn-primary-outer ripple">
                                        <input class="rsFormSubmit btn btn-lg btn-primary" type="submit"
                                               value="<?= _('Send') ?>">
                                    </span>
                                </form>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="section-box contact-info">
                                <ul class="contact-list">
                                    <li class="clearfix">
                                        <strong><?= _('Address') ?></strong>
                                        <span><?= _('Hungary, Debrecen') ?></span>
                                    </li>
                                    <li class="clearfix">
                                        <strong>LinkedIn</strong>
                                        <span><a href="https://www.linkedin.com/in/pappfer">linkedin.com/in/pappfer</a></span>
                                    </li>
                                    <li class="clearfix">
                                        <strong><?= _('Email') ?></strong>
                                        <span><a href="mailto:pappfer@pappfer.hu">pappfer@pappfer.hu</a></span>
                                    </li>
                                </ul>

                                <img src="<?= $root ?>img/debrecen.png" alt="Debrecen" width="455" height="410">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- #contact -->
            <!-- END: PAGE CONTENT -->

        </div>
        <!-- .container -->
    </div>
    <!-- .content -->

    <footer class="footer">
        <div class="footer-social">
            <ul class="social">
                <li><a class="ripple-centered" href="https://twitter.com/pappfer" target="_blank"><i
                                class="rsicon rsicon-twitter"></i></a></li>
                <li><a class="ripple-centered" href="https://www.linkedin.com/in/pappfer" target="_blank"><i
                                class="rsicon rsicon-linkedin"></i></a></li>
                <li><a class="ripple-centered" href="https://github.com/pappfer" target="_blank"><i
                                class="rsicon rsicon-github"></i></a></li>
                <li><a class="ripple-centered" href="https://stackoverflow.com/users/3736962/pappfer" target="_blank"><i
                                class="rsicon rsicon-stack-overflow"></i></a></li>
            </ul>
        </div>
    </footer>
    <!-- .footer -->

</div>
<!-- .wrapper -->

<a class="btn-scroll-top" href="#"><i class="rsicon rsicon-arrow-up"></i></a>

<div id="overlay"></div>
<div id="preloader">
    <div class="preload-icon"><span></span><span></span></div>
    <div class="preload-text"><?= _('Loading...') ?></div>
</div>

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="<?= assetPath('bundle.js', 'js') ?>"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-50016491-1"></script>
<script>
  window.dataLayer = window.dataLayer || []

  function gtag () {
    dataLayer.push(arguments)
  }

  gtag('js', new Date())

  gtag('config', 'UA-50016491-1')
</script>

</body>
</html>
