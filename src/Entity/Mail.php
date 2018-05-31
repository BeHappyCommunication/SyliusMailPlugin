<?php

declare(strict_types = 1);

namespace BeHappy\SyliusMailPlugin\Entity;

class Mail
{
    /** @var string */
    protected $receiver = "";
    /** @var string */
    protected $content = "";
    /** @var string */
    protected $title = "";
    /** @var MailConfiguration|null */
    protected $configuration = null;

    /**
     * @return string
     */
    public function getReceiver(): string
    {
        return $this->receiver;
    }

    /**
     * @param string $receiver
     * @return Mail
     */
    public function setReceiver(string $receiver): Mail
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Mail
     */
    public function setContent(string $content): Mail
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return MailConfiguration|null
     */
    public function getConfiguration(): ?MailConfiguration
    {
        return $this->configuration;
    }

    /**
     * @param MailConfiguration|null $configuration
     * @return Mail
     */
    public function setConfiguration(?MailConfiguration $configuration): Mail
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
}