<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExternalData;

class ImportExternalData extends Command
{
    protected $signature = 'import:external-data';
    protected $description = 'Importa e atualiza dados da API externa';

    public function handle()
    {
        $url = "https://hub.alpes.one/api/v1/integrator/export/1902";

        try {
            $json = file_get_contents($url);
            $data = json_decode($json, true);

            if (!is_array($data)) {
                $this->error("Erro: JSON inválido");
                return;
            }

            foreach ($data as $item) {
                ExternalData::updateOrCreate(
                    ['codigo' => $item['codigo']],
                    [
                        'nome' => $item['nome'],
                        'descricao' => $item['descricao'] ?? null
                    ]
                );
            }

            $this->info("Dados importados/atualizados com sucesso.");
        } catch (\Exception $e) {
            $this->error("Erro ao importar: " . $e->getMessage());
        }
    }
}