<?php echo  '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   @foreach ($posts as $post)
       
   <url>

      <loc>{{}}</loc>

      <lastmod>2005-01-01</lastmod>

      <changefreq>monthly</changefreq>

      <priority>0.8</priority>

   </url>
   @endforeach 

</urlset> 
