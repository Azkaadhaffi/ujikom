<?php
// mengaktifkan session php
session_start();

// menonaktifkan session php

session_destroy();
header("location:../index.php?pesan=logout");
