<?php
    function procesar_mes($data) {
        $mes = "";

        switch (date_parse($data)["month"]) {
            case 1:
                $mes = "Xaneiro";
                break;
            case 2:
                $mes = "Febreiro";
                break;
            case 3:
                $mes = "Marzo";
                break;
            case 4:
                $mes = "Abril";
                break;
            case 5:
                $mes = "Maio";
                break;
            case 6:
                $mes = "Xuño";
                break;
            case 7:
                $mes = "Xullo";
                break;
            case 8:
                $mes = "Agosto";
                break;
            case 9:
                $mes = "Septembro";
                break;
            case 10:
                $mes = "Outubro";
                break;
            case 11:
                $mes = "Novembro";
                break;
            case 12:
                $mes = "Decembro";
                break;
        }

        return $mes;
    }

    function procesar_dia($data) {

        return date_parse($data)["day"];

    }

    function procesar_anho($data) {

        return date_parse($data)["year"];
        
    }

    function procesar_diasemana($data) {

        $dia_semana = "";

        switch (date('w', strtotime($data))) {

            case 0:
                $dia_semana = "Domingo";
                break;
            case 1:
                $dia_semana = "Luns";
                break;
            case 2:
                $dia_semana = "Martes";
                break;
            case 3:
                $dia_semana = "Mércores";
                break;
            case 4:
                $dia_semana = "Xoves";
                break;
            case 5:
                $dia_semana = "Venres";
                break;
            case 6:
                $dia_semana = "Sábado";
                break;
        };

        return $dia_semana;
        
    }

    function procesar_hora($data) {

        return date('H', strtotime($data));

    }

    function procesar_minuto($data) {

        return date('i', strtotime($data));

    }

    function procesar_segundo($data) {

        return date('s', strtotime($data));

    }

    function procesar_datamail($data) {

        if (
            date("d",strtotime($data)) == date("d") &&
            date("W",strtotime($data)) == date("W") &&
            date("Y",strtotime($data)) == date("Y")
        ) {

            return procesar_hora($data) . ":" . procesar_minuto($data);
        } else if (
            date("d",strtotime($data)) != date("d") &&
            date("W",strtotime($data)) == date("W") &&
            date("Y",strtotime($data)) == date("Y")
        ) {

            return procesar_diasemana($data);
        } else if (
            date("d",strtotime($data)) != date("d") &&
            date("W",strtotime($data)) != date("W") &&
            date("Y",strtotime($data)) == date("Y")
        ) {

            return procesar_dia($data) . " " . substr(procesar_mes($data),0,3);
        }
    }