<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
            'nama' => $row[1],
            'jenkel' => $row[2],
            'notlp' => $row[3],
            'foto' => $row[4],
        ]);

        // $table->id();
        //     $table->string('nama');
        //     $table->enum('jenkel',['cowo','cewe']);
        //     $table->bigInteger('notlp');
        //     $table->string('foto');
        //     $table->timestamps();
    }
}
