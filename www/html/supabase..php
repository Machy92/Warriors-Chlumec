<?php
require 'vendor/autoload.php';

use Supabase\SupabaseClient;

$supabaseUrl = 'https://opytqyxheeezvwncboly.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im9weXRxeXhoZWVlenZ3bmNib2x5Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NDc2NDAyMTMsImV4cCI6MjA2MzIxNjIxM30.h_DdvClVy4-xbEkQ3AWQose3dqPaxPQ1gl-LaLhwtCE';

$supabase = new SupabaseClient($supabaseUrl, $supabaseKey);

function isAdmin($supabase, $userId) {
  if (!$userId) return false;
  $response = $supabase->from('profiles')->select('pozice')->eq('id', $userId)->single();
  return isset($response["pozice"]) && $response["pozice"] === 'admin';
}
