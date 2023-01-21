<?php

namespace Passionweb\FormEmailContentblocks\Domain\Finishers;


use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;

class ExtendFluidEmailFinisher extends AbstractFinisher
{
    protected function executeInternal()
    {
        /**
         * check if a valid hexidecimal string was entered
         */
        if(ctype_xdigit(substr($this->options['bgColor'], 1)) && (strlen($this->options['bgColor']) === 4 || strlen($this->options['bgColor']) === 7)) {
            $this->finisherContext->getFinisherVariableProvider()->add(
                $this->shortFinisherIdentifier,
                'backgroundColor',
                $this->options['bgColor']
            );
        }

        $this->finisherContext->getFinisherVariableProvider()->add(
            $this->shortFinisherIdentifier,
            'logo',
            $this->options['logo']
        );
    }

}
