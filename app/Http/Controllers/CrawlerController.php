<?php

namespace App\Http\Controllers;

use App\Models\CrawlerHoroscope;
use App\Services\CrawlerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CrawlerController extends Controller
{
    protected $crawlerService;
    protected $crawlerHoroscope;

    public function __construct()
    {
        $this->crawlerService = new CrawlerService();
        $this->crawlerHoroscope = new CrawlerHoroscope();
    }

    public function testGetOriginalData()
    {
//        $crawler = $this->crawlerService->getOriginalData('http://astro.click108.com.tw/daily_11.php?iAstro=11');
        $crawler = $this->crawlerService->getOriginalData('http://astro.click108.com.tw/daily_11.php?iAstro=11');
//        $this->assertNotEmpty($crawler->html());
        dd($crawler);
    }

    public function getHoroscope()
    {
        $date = Carbon::parse(now())->toDateString();
        $data = array();
        for ($i = 0; $i < 12; $i++){
            $path = 'http://astro.click108.com.tw/daily_'.$i.'.php?iAcDay='.$date.'&iAstro='.$i;
            $crawlerAll = $this->crawlerService->getOriginalData($path);
            $data[$i] = $this->crawlerService->getTodayFortune($crawlerAll);//get info except date
        }

        $storeData = array();
        foreach ($data as $key => $value){
            $storeData[$key]['date'] = $date;
            $storeData[$key]['name'] = $value['name'];
            $storeData[$key]['overall_score'] = $value[0];
            $storeData[$key]['overall_description'] = $value[1];
            $storeData[$key]['love_score'] = $value[2];
            $storeData[$key]['love_description'] = $value[3];
            $storeData[$key]['work_score'] = $value[4];
            $storeData[$key]['work_description'] = $value[5];
            $storeData[$key]['finance_score'] = $value[6];
            $storeData[$key]['finance_description'] = $value[7];
            $storeData[$key]['create_time'] = Carbon::parse(now())->toDateTimeString();
        }
        $result = $this->crawlerHoroscope->create($storeData);

        if ($result){
            return 'success';
        }else{
            return 'fail';
        }
    }


}
