<?php

namespace TodoBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use DateTime;
use TodoBundle\Entity\Todo;
use Doctrine\ORM\EntityManagerInterface;

class CreateTodoCommand extends Command
{

    protected static $defaultName = 'todo:create-todo';

  

    protected function configure()
    {
        $this
        ->setDescription('Crear nueva tarea')
        ->setHelp('Este comando permite crear una nueva tarea...')
        ->addArgument('nombre_tarea', InputArgument::REQUIRED, 'Nombre de la tarea.')
        ->addArgument('fecha_tope', InputArgument::REQUIRED, 'Fecha tope de la tarea.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'TASK Creator',
            '============',
            '',
        ]);


        $nombre = $input->getArgument('nombre_tarea');
        $fecha_tope = $input->getArgument('fecha_tope');
        if(!$this->validarFecha($fecha_tope)){
            $output->writeln('La fecha tiene un formato incorrecto. Debe ser d/m/Y (ejemplo: 01/08/2020).');
            return;
        } 
        
        $new = new Todo();
        $new->setNombre($nombre);
        $new->setFechaCreacion( new DateTime(date('Y-m-d H:i:s')));
        $new->setFechaTope( new DateTime(date('Y-m-d H:i:s',strtotime($fecha_tope))));
        $new->setEstado(false);


        //TO DO: meter en BD

        $output->writeln([
            '============',
            'Tarea creada',
            '',
        ]);
    
    }

    function validarFecha($date, $format = 'd/m/Y')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}