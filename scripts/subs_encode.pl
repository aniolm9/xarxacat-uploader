#!/usr/bin/perl
use strict;
use warnings;
use autodie qw(:all);

sub encode {
    my $queue_file = "queue.php";
    
    # Path related variables.
    my $base = "$_[0]";
    my $relpath = "$_[1]";
    my $abspath = "$base$relpath";
    my $abspath_noextension = substr($abspath, 0, rindex($abspath, '.') - length($abspath));
    my $escaped_relpath = quotemeta($relpath);
    my $escaped_abspath = quotemeta($abspath);
    
    # Encode file
    my @ffmpeg = ("ffmpeg", "-nostats", "-nostdin", "-i", "$abspath", "-map", "0:v:0", "-map", "0:a:0", "-vf", "subtitles=$escaped_abspath", "$abspath_noextension.mp4");
    system(@ffmpeg);

    # Delete uploaded file
    unlink "$abspath";

    # Delete file from queue
    my $perl = "perl -i -ne '/$escaped_relpath/ || print' $queue_file";
    system($perl);
}

encode($ARGV[0], $ARGV[1]);
