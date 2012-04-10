# Graphite Filler

Tool for creating historical data in Graphite, used for testing your config without having to wait long periods for data.

## Parameters

### date

Start filling from this date, use the normal syntax: yyyy-mm-dd

    fill.php --date 2012-01-01

### time

Like date, start filling from this time.

    fill.php --time 01:31:03

### interval

The default interval is every 1 second, but change it with this.

    fill.php --interval 10

is 10 seconds

### max

By default the max value fill will add is 10, but change it with this.

    fill.php --max 30

### host

fill connects to localhost by default, override it with this setting

    fill.php --host graphite.dev

### port

Uses Graphit's default port of 2003, but if you have it running on a different port, use this option to change it.

    fill.php --port 2020

### stat

The default stat name is "test.stat", but change it with this option.

    fill.php --stat stats.timers.script
