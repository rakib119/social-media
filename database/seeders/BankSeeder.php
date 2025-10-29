<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('banks')->delete();

		$banks = array(
            ['id'=>1,'name' => 'Bangladesh Bank', 'category' => 'Central Bank','bank_type'=>1],
            ['id'=>2,'name' => 'Sonali Bank', 'category' => 'State-owned Commercial','bank_type'=>1],
            ['id'=>3,'name' => 'Agrani Bank', 'category' => 'State-owned Commercial','bank_type'=>1],
            ['id'=>4,'name' => 'Rupali Bank', 'category' => 'State-owned Commercial','bank_type'=>1],
            ['id'=>5,'name' => 'Janata Bank', 'category' => 'State-owned Commercial','bank_type'=>1],
            ['id'=>6,'name' => 'BRAC Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>7,'name' => 'Dutch Bangla Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>8,'name' => 'Eastern Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>9,'name' => 'United Commercial Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>10,'name' => 'Mutual Trust Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>11,'name' => 'Dhaka Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>12,'name' => 'Islami Bank Bangladesh Ltd', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>13,'name' => 'Uttara Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>14,'name' => 'Pubali Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>15,'name' => 'IFIC Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>16,'name' => 'National Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>17,'name' => 'The City Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>18,'name' => 'NCC Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>19,'name' => 'Mercantile Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>20,'name' => 'Southeast Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>21,'name' => 'Prime Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>22,'name' => 'Social Islami Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>23,'name' => 'Standard Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>24,'name' => 'Al-Arafah Islami Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>25,'name' => 'One Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>26,'name' => 'Exim Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>27,'name' => 'First Security Islami Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>28,'name' => 'Bank Asia Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>29,'name' => 'The Premier Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>30,'name' => 'Bangladesh Commerce Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>31,'name' => 'Trust Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>32,'name' => 'Jamuna Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>33,'name' => 'Shahjalal Islami Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>34,'name' => 'ICB Islamic Bank', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>35,'name' => 'AB Bank', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>36,'name' => 'Jubilee Bank Limited', 'category' => 'Private Commercial','bank_type'=>1],
            ['id'=>37,'name' => 'Karmasangsthan Bank', 'category' => 'Specialized Development','bank_type'=>1],
            ['id'=>38,'name' => 'Bangladesh Krishi Bank', 'category' => 'Specialized Development','bank_type'=>1],
            ['id'=>39,'name' => 'Progoti Bank', 'category' => '','bank_type'=>1],
            ['id'=>40,'name' => 'Rajshahi Krishi Unnayan Bank', 'category' => 'Specialized Development','bank_type'=>1],
            ['id'=>41,'name' => 'BangladeshDevelopment Bank Ltd', 'category' => 'Specialized Development','bank_type'=>1],
            ['id'=>42,'name' => 'Bangladesh Somobay Bank Limited', 'category' => 'Specialized Development','bank_type'=>1],
            ['id'=>43,'name' => 'Grameen Bank', 'category' => 'Specialized Development','bank_type'=>1],
            ['id'=>44,'name' => 'BASIC Bank Limited', 'category' => 'Specialized Development','bank_type'=>1],
            ['id'=>45,'name' => 'Ansar VDP Unnyan Bank', 'category' => 'Specialized Development','bank_type'=>1],
            ['id'=>46,'name' => 'The Dhaka Mercantile Co-operative Bank Limited(DMCBL)', 'category' => 'Specialized Development','bank_type'=>1],
            ['id'=>47,'name' => 'Citibank', 'category' => 'Foreign Commercial','bank_type'=>1],
            ['id'=>48,'name' => 'HSBC', 'category' => 'Foreign Commercial','bank_type'=>1],
            ['id'=>49,'name' => 'Standard Chartered Bank', 'category' => 'Foreign Commercial','bank_type'=>1],
            ['id'=>50,'name' => 'CommercialBank of Ceylon', 'category' => 'Foreign Commercial','bank_type'=>1],
            ['id'=>51,'name' => 'State Bank of India', 'category' => 'Foreign Commercial','bank_type'=>1],
            ['id'=>52,'name' => 'WooriBank', 'category' => 'Foreign Commercial','bank_type'=>1],
            ['id'=>53,'name' => 'Bank Alfalah', 'category' => 'Foreign Commercial','bank_type'=>1],
            ['id'=>54,'name' => 'National Bank of Pakistan', 'category' => 'Foreign Commercial','bank_type'=>1],
            ['id'=>55,'name' => 'ICICI Bank', 'category' => 'Foreign Commercial','bank_type'=>1],
            ['id'=>56,'name' => 'Habib Bank Limited', 'category' => 'Foreign Commercial','bank_type'=>1],
            ['id'=>57,'name' => 'ROCKET','category' => 'Dutch Bangla Bank Ltd.','bank_type'=>2],
            ['id'=>58,'name' => 'bKash','category' => 'bKash Ltd.','bank_type'=>2],
            ['id'=>59,'name' => 'MYCash','category' => 'Mercantile Bank Ltd.','bank_type'=>2],
            ['id'=>60,'name' => 'Islami Bank mCash','category' => 'Islami Bank Bangladesh Ltd.','bank_type'=>2],
            ['id'=>61,'name' => 'Trust Axiata Pay: tap','category' => 'Trust Axiata Digital Ltd.','bank_type'=>2],
            ['id'=>62,'name' => 'FirstCash','category' => 'First Security Islami Bank Ltd.','bank_type'=>2],
            ['id'=>63,'name' => 'উপায় (Upay)','category' => 'UCB Fintech Company Ltd.','bank_type'=>2],
            ['id'=>64,'name' => 'OK Wallet','category' => 'One Bank Ltd.','bank_type'=>2],
            ['id'=>65,'name' => 'TeleCash','category' => 'Southeast Bank Ltd.','bank_type'=>2],
            ['id'=>66,'name' => 'Islamic Wallet','category' => 'Al-Arafah Islami Bank Ltd.','bank_type'=>2],
            ['id'=>67,'name' => 'Meghna Pay','category' => 'Meghna Bank Ltd.','bank_type'=>2],
            ['id'=>68,'name' => 'Nagad','category' => 'Bangladesh Post Office (with interim approval of BB)','bank_type'=>2]
        );

		DB::table('banks')->insert($banks);
    }
}
