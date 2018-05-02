<?php

namespace Eduardokum\LaravelMailAutoEmbed\Embedder;

use Swift_Image;
use Swift_Message;
use Swift_EmbeddedFile;
use Eduardokum\LaravelMailAutoEmbed\Models\EmbeddableEntity;

class AttachmentEmbedder extends Embedder
{
    /**
     * @var  Swift_Message
     */
    protected $message;

    /**
     * AttachmentEmbedder constructor.
     * @param  Swift_Message $message
     */
    public function __construct(Swift_Message $message)
    {
        $this->message = $message;
    }

    /**
     * @param  string  $url
     */
    public function fromUrl($url)
    {
        //Skipping Check to allow absolute URLS
        return $this->embed(
            Swift_Image::fromPath($url)
        );
    }

    /**
     * @param  EmbeddableEntity  $entity
     */
    public function fromEntity(EmbeddableEntity $entity)
    {
        return $this->embed(
            new Swift_EmbeddedFile(
                $entity->getRawContent(),
                $entity->getFileName(),
                $entity->getMimeType()
            )
        );
    }

    /**
     * @param  Swift_EmbeddedFile  $attachment
     * @return string
     */
    protected function embed(Swift_EmbeddedFile $attachment)
    {
        return $this->message->embed($attachment);
    }
}
