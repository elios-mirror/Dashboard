#!/usr/bin/env bash
process=$(screen -ls | grep scw-02a03d)

echo $process | cut -f1 -d'.' > old_id