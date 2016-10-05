# Symfify composer plugin

[![Build Status](https://scrutinizer-ci.com/g/jakzal/symfify/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jakzal/symfify/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jakzal/symfify/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jakzal/symfify/?branch=master)
[![Build Status](https://travis-ci.org/jakzal/symfify.svg?branch=master)](https://travis-ci.org/jakzal/symfify)

This composer plugin will set up a basic Symfony project in a code base that did not start as a Symfony project.
It's useful when you're test driving your application from zero, starting in the center, and adding
infrastructure (like the framework) later.

At the moment this is a simple proof of concept, setting up a basic front controller with an
application micro kernel.

## Installation

Install the plugin globally to access it from anywhere:

    composer global require zalas/symfify

## Usage

    composer symfify .

## Demo

![Symfify demo](http://g.recordit.co/IM8UyJt0tV.gif)
