# meta-audio
A PHP library to read and write metadata tags to audio files (MP3, ID3, APE, etc)

__WARNING: This library is still very much experimental, and will likely corrupt your beloved audio files, use with caution (and backups)__

Full documentation is available at https://duncan3dc.github.io/meta-audio/  
PHPDoc API documentation is also available at [https://duncan3dc.github.io/meta-audio/api/](https://duncan3dc.github.io/meta-audio/api/namespaces/duncan3dc.MetaAudio.html)  

[![Build Status](https://img.shields.io/travis/duncan3dc/meta-audio.svg)](https://travis-ci.org/duncan3dc/meta-audio)
[![Latest Version](https://img.shields.io/packagist/v/duncan3dc/meta-audio.svg)](https://packagist.org/packages/duncan3dc/meta-audio)


## Installation
Using [composer](https://packagist.org/packages/duncan3dc/meta-audio):
```bash
$ composer require duncan3dc/meta-audio
```


## Quick Example
```php
$tagger = new \duncan3dc\MetaAudio\Tagger;
$tagger->addDefaultModules();

$mp3 = $tagger->open("/var/music/song.mp3");

$mp3->getArtist();
$mp3->getAlbum();
$mp3->getYear();
$mp3->getNumber();
$mp3->getTitle();
```

_Read more at http://duncan3dc.github.io/meta-audio/_  


## Changelog
A [Changelog](CHANGELOG.md) has been available since the beginning of time


## Where to get help
Found a bug? Got a question? Just not sure how something works?  
Please [create an issue](//github.com/duncan3dc/meta-audio/issues) and I'll do my best to help out.  
Alternatively you can catch me on [Twitter](https://twitter.com/duncan3dc)
