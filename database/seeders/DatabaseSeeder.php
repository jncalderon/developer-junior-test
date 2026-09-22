<?php
namespace Database\Seeders;
use App\Models\Category; use App\Models\Product; use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder { public function run():void {
    $hardware=Category::create(['name'=>'Hardware']); $office=Category::create(['name'=>'Oficina']); $network=Category::create(['name'=>'Redes']);
    $rows = [
      [$hardware,'Monitor 24 pulgadas','MON-024',8,'A-01',129.90,true],
      [$office,'Teclado USB','TEC-USB',3,'B-04',18.50,true],
      [$network,'Switch 8 puertos','SW-008',12,'C-02',44.00,true],
      [$hardware,'Mouse inalámbrico','MOU-WL1',0,'A-03',22.75,false],
      [$office,'Silla ergonómica','SIL-ERG',6,'B-01',189.00,true],
      [$network,'Router WiFi 6','RTR-WF6',4,'C-05',95.00,true],
      [$hardware,'Webcam HD','WEB-HD1',2,'A-07',39.90,true],
      [$office,'Base para laptop','BAS-LAP',9,'B-06',28.25,true],
      [$network,'Cable de red 3m','CAB-003',20,'C-08',6.50,true],
    ];
    foreach ($rows as [$cat,$name,$sku,$stock,$location,$price,$active]) {
        Product::create(['category_id'=>$cat->id,'name'=>$name,'sku'=>$sku,'stock'=>$stock,'location'=>$location,'price'=>$price,'active'=>$active]);
    }
} }
