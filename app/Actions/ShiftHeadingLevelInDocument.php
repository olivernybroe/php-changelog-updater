<?php

declare(strict_types=1);

namespace App\Actions;

use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Node\Block\Document;
use League\CommonMark\Node\Query;

class ShiftHeadingLevelInDocument
{
    public function execute(Document $document, int $baseHeadingLevel): Document
    {
        $headings = (new Query())
            ->where(Query::type(Heading::class))
            ->findAll($document);

        /** @var Heading $heading */
        foreach ($headings as $heading) {

            // Don't shift heading if level is above base level
            if ($heading->getLevel() >= $baseHeadingLevel) {
                continue;
            }

            // TODO: Should we keep the hierarchy of all headings intact?
            $diffToDesiredLevel = $baseHeadingLevel - $heading->getLevel();
            $heading->setLevel($heading->getLevel() + $diffToDesiredLevel);
        }

        return $document;
    }
}
