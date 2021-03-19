<?php
/**
 * Основне поставке Вордпреса.
 *
 * Ова датотека се користи од стране скрипте за прављење wp-config.php током
 * инсталирања. Не морате да користите веб место, само умножите ову датотеку
 * у "wp-config.php" и попуните вредности.
 *
 * Ова датотека садржи следеће поставке:
 * * MySQL подешавања
 * * тајне кључеве
 * * префикс табеле
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL подешавања - Можете добити ове податке од свог домаћина ** //
/** Име базе података за Вордпрес */
define( 'DB_NAME', 'milan_kovace_forwardslash_fe_test' );

/** Корисничко име MySQL базе */
define( 'DB_USER', 'root' );

/** Лозинка MySQL базе */
define( 'DB_PASSWORD', '' );

/** MySQL домаћин */
define( 'DB_HOST', 'localhost' );

/** Скуп знакова за коришћење у прављењу табела базе. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Не мењајте ово ако сте у сумњи. */
define( 'DB_COLLATE', '' );

/**#@+
 * Јединствени кључеви за аутентификацију.
 *
 * Промените ово у различите јединствене изразе!
 * Можете направити ово користећи {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org услугу тајних кључева}
 * Ово можете променити у сваком тренутку да бисте поништили све постојеће колачиће.
 * Ово ће натерати кориснике да се поново пријаве.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '^g~C2zKH>F^/2fITCvj}~o,!9L^<de ~[[u^-g[f(sD]>7eK3WQ^<Z)$[!(+tONz' );
define( 'SECURE_AUTH_KEY',  '&;l7+ +{?^qfg)Md.,] }0E}P.`^o~_[`e*?HzkW;H yaLF/4;gU@g`]FF&+RV]8' );
define( 'LOGGED_IN_KEY',    '4!W,PB:TY~<E,QP|`s>|3c 7hHj033z_[~n* @i}z!,]b=9shK7UsN>>Y8oh-(/i' );
define( 'NONCE_KEY',        'K}}3,9i3vpz;&0^dOC%/UCLY;LY%uy9EV&$O=Z.ya:. mSY!:(N^2d~tbQ;dy`op' );
define( 'AUTH_SALT',        'w /dXBFXO5HBwm,fK#=xzv;4u;``dqedL4Yr}-mLihc7>o1^y}X=+GcT$f(zIPuU' );
define( 'SECURE_AUTH_SALT', '7C6c)-znoIdevo!!qu9 XygtOS^?[GL1~2B&XI_CkU-0XN5q6@V~jci;r@|/,Q:S' );
define( 'LOGGED_IN_SALT',   ':419he~M0W@Tg~E-DL>]:Sac$RA7Vj+|0zpyqC(B+j98a^.kIu0/6W[p2zS{-MKw' );
define( 'NONCE_SALT',       'Uo*8{pktwgqh/6(k3Z]Cz|wNzV+K^t;O#q!6!WW;3_8%T=]z]eCNFdZs+da ogRE' );
define('JWT_AUTH_SECRET_KEY', 'Uo*8{pktwgqh/6(k3Z]Cz|wNzV+K^t;O#q!6!WW;3_8%T=]');
define('JWT_AUTH_CORS_ENABLE', true);

/**#@-*/

/**
 * Префикс табеле Вордпресове базе података.
 *
 * Можете имати више инсталација Вордпреса у једној бази уколико
 * свакој дате јединствени префикс. Само бројеви, слова и доње цртице!
 */
$table_prefix = 'wp_';

/**
 * За градитеље: исправљање грешака у Вордпресу ("WordPress debugging mode").
 *
 * Промените ово у true да бисте омогућили приказ напомена током градње.
 * Веома се препоручује да градитељи тема и додатака користе WP_DEBUG
 * у својим градитељским окружењима.
 *
 * За више података о осталим константама које могу да се
 * користе током отклањања грешака, посетите Документацију.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* То је све, престаните са уређивањем! Срећно објављивање. */

/** Апсолутна путања ка Вордпресовом директоријуму. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Поставља Вордпресове променљиве и укључене датотеке. */
require_once( ABSPATH . 'wp-settings.php' );
