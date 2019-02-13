#!/usr/bin/perl
use strict;
use warnings;

sub encode {
    my $queue_file = "queue.php";
    
    # Path related variables.
    my $base = "$_[0]";
    my $relpath = "$_[1]";
    my $abspath = "$base$relpath";
    (my $abspath_noextension = $abspath) =~ s/\.[^.]+$//;
    my $escaped_relpath = quotemeta($relpath);
    
    # Commands
    if (qx{mediainfo $abspath | grep \"Writing library\" | sed -n 2p | cut -d \":\" -f 2 | cut -d \" \" -f 2} ne "x264\n") {
        my @ffmpeg = ("ffmpeg", "-nostats", "-nostdin", "-i", "$abspath", "-vcodec", "libx264", "-acodec", "libmp3lame", "-map", "0:v:0", "-map", "0:a:0", "$abspath_noextension.mp4");
        system(@ffmpeg);
    }
    else {
        my @ffmpeg = ("ffmpeg", "-nostats", "-nostdin", "-i", "$abspath", "-vcodec", "copy", "-acodec", "libmp3lame", "-map", "0:v:0", "-map", "0:a:0", "$abspath_noextension.mp4");
        system(@ffmpeg);
    }
    
    if ($? == 0) {
        my @rm = ("rm", "$abspath");
        system(@rm);
        
        if ($? == 0) {
            my $perl = "perl -i -ne '/$escaped_relpath/ || print' $queue_file";
            system($perl);
        }
    }
}

encode($ARGV[0], $ARGV[1]);
