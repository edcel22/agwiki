<?php
/**
 * Whoops - php errors for cool kids
 * @author Filipe Dobreira <https://github.com/filp>
 */

namespace Whoops\Inspector;

interface InspectorFactoryInterface
{
    /**
     * @param \Throwable $exception
     * @return InspectorInterface
     */
    public function create($exception);
}
