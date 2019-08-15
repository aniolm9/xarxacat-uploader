#!/usr/bin/perl
use strict;
use warnings;
use autodie qw(:all);

sub encode {
    my $queue_file          = "queue.php";
    my $subs                = "$_[2]";

    # Path related variables.
    my $base                = "$_[0]";
    my $relpath             = "$_[1]";
    my $abspath             = "$base$relpath";
    my $abspath_noextension = substr($abspath, 0, rindex($abspath, '.') - length($abspath));
    my $escaped_relpath     = quotemeta($relpath);
    my $escaped_abspath     = quotemeta($abspath);
    
    # Encode file
    if ($subs eq "with-subs") {
        my @ffmpeg = ("ffmpeg", "-nostats", "-nostdin", "-i", "$abspath", "-map", "0:v:0", "-map", "0:a:0", "-vf",
                        "subtitles=$escaped_abspath", "$abspath_noextension.mp4");
        system(@ffmpeg);
    }
    elsif (qx{mediainfo $abspath | grep \"Writing library\" | sed -n 2p | cut -d \":\" -f 2 | cut -d \" \" -f 2} ne "x264\n") {
        my @ffmpeg = ("ffmpeg", "-nostats", "-nostdin", "-i", "$abspath", "-vcodec", "libx264", "-acodec", "libmp3lame",
                        "-map", "0:v:0", "-map", "0:a:0", "$abspath_noextension.mp4");
        system(@ffmpeg);
    }
    else {
        my @ffmpeg = ("ffmpeg", "-nostats", "-nostdin", "-i", "$abspath", "-vcodec", "copy", "-acodec", "libmp3lame",
                        "-map", "0:v:0", "-map", "0:a:0", "$abspath_noextension.mp4");
        system(@ffmpeg);
    }

    # Delete uploaded file
    unlink "$abspath";

    # Delete file from queue
    local ($^I, @ARGV) = ("", $queue_file);
    while(<>) {
        print unless /$escaped_relpath/;
    }

    return;
}

encode($ARGV[0], $ARGV[1], $ARGV[2]);
