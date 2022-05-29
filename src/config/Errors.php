<?php

use Tracy\Debugger;

// Habilita Tela de Erro com Trace.
Debugger::enable(Debugger::DEVELOPMENT);
Debugger::$showBar = false;
