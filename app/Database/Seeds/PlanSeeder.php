<?php

namespace App\Database\Seeds;

use App\Models\PlanModel;
use CodeIgniter\Config\Factories;
use CodeIgniter\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run()
    {
        try {

            $this->db->transStart();

            $planModel = Factories::models(PlanModel::class);

            foreach (self::plans() as $plan) {

                $planModel->insert($plan);
            }

            $this->db->transComplete();

            echo 'Planos criados com sucesso!';
        } catch (\Throwable $th) {

            log_message('error', '[ERROR] {exception}', ['exception' => $th]);

            print $th;
        }
    }


    private static function plans(): array
    {
        return [
            [

                "plan_id" => 9099,
                "name" => "Plano Mensal Lindo demais",
                "recorrence" => "monthly",
                "adverts" => 10,
                "description" => "Plano Mensal Lindo demais",
                "value" => 39.90,
                "is_highlighted" => 0,

            ],
            [

                "plan_id" => 9100,
                "name" => "Plano Trimestral Espetacular",
                "recorrence" => "quarterly",
                "adverts" => 20,
                "description" => "Plano Trimestral Espetacular",
                "value" => 99.00,
                "is_highlighted" => 0,

            ],
            [

                "plan_id" => 9101,
                "name" => "Plano Semestral Lindão",
                "recorrence" => "semester",
                "adverts" => NULL,
                "description" => "Plano Semestral Lindão",
                "value" => 199.99,
                "is_highlighted" => 1,

            ],
            [

                "plan_id" => 9102,
                "name" => "Plano Anual Imperdível",
                "recorrence" => "yearly",
                "adverts" => NULL,
                "description" => "Plano Anual Imperdível",
                "value" => 360.00,
                "is_highlighted" => 1,
            ],
        ];
    }
}
