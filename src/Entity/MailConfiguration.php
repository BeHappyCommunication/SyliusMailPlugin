<?php

declare(strict_types = 1);

namespace BeHappy\SyliusMailPlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * Class MailConfiguration
 *
 * @package BeHappy\MailPlugin\Entity
 */
class MailConfiguration implements ResourceInterface
{
    const ENCRYPTION = [
        'behappy_mail_plugin.ui.form.encryption.ssl' => self::ENCRYPTION_SSL,
        'behappy_mail_plugin.ui.form.encryption.tls' => self::ENCRYPTION_TLS,
    ];

    const TYPE = [
        'behappy_mail_plugin.ui.form.type.direct' => self::TYPE_DIRECT,
        'behappy_mail_plugin.ui.form.type.smtp' => self::TYPE_SMTP
    ];

    const TYPE_DIRECT = 1;
    const TYPE_SMTP = 2;
    
    const ENCRYPTION_NONE = 1;
    const ENCRYPTION_SSL = 2;
    const ENCRYPTION_TLS = 3;

    /** @var int */
    protected $id = 0;
    /** @var string|null */
    protected $smtpHost = null;
    /** @var int|null */
    protected $smtpPort = null;
    /** @var string|null */
    protected $smtpUser = null;
    /** @var string|null */
    protected $smtpPassword = null;
    /** @var bool */
    protected $dkim = false;
    /** @var string|null */
    protected $dkimDomain = null;
    /** @var string|null */
    protected $dkimSelector = null;
    /** @var string|null */
    protected $dkimKey = null;
    /** @var string */
    protected $senderName = '';
    /** @var string */
    protected $senderMail = '';
    /** @var string|null */
    protected $replyToMail = null;
    /** @var int */
    protected $encryption = self::ENCRYPTION_SSL;
    /** @var ArrayCollection|Channel[]|null */
    protected $channels = null;
    /** @var int */
    protected $type = self::TYPE_DIRECT;

    /**
     * MailConfiguration constructor.
     */
    public function __construct()
    {
        $this->setChannels(new ArrayCollection());
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getSmtpHost(): ?string
    {
        return $this->smtpHost;
    }

    /**
     * @param string|null $smtpHost
     *
     * @return MailConfiguration
     */
    public function setSmtpHost(?string $smtpHost): MailConfiguration
    {
        $this->smtpHost = $smtpHost;
    
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSmtpPort(): ?int
    {
        return $this->smtpPort;
    }

    /**
     * @param int|null $smtpPort
     *
     * @return MailConfiguration
     */
    public function setSmtpPort(?int $smtpPort): MailConfiguration
    {
        $this->smtpPort = $smtpPort;
    
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSmtpUser(): ?string
    {
        return $this->smtpUser;
    }

    /**
     * @param string|null $smtpUser
     *
     * @return MailConfiguration
     */
    public function setSmtpUser(?string $smtpUser): MailConfiguration
    {
        $this->smtpUser = $smtpUser;
    
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSmtpPassword(): ?string
    {
        return $this->smtpPassword;
    }

    /**
     * @param string|null $smtpPassword
     *
     * @return MailConfiguration
     */
    public function setSmtpPassword(?string $smtpPassword): MailConfiguration
    {
        $this->smtpPassword = $smtpPassword;
    
        return $this;
    }

    /**
     * @return bool
     */
    public function getDkim(): bool
    {
        return $this->dkim;
    }
    
    /**
     * @return bool
     */
    public function isDkim(): bool
    {
        return $this->getDkim();
    }
    
    /**
     * @param bool $dkim
     *
     * @return MailConfiguration
     */
    public function setDkim(bool $dkim = false): MailConfiguration
    {
        $this->dkim = $dkim;
    
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    /**
     * @param string $senderName
     *
     * @return MailConfiguration
     */
    public function setSenderName(string $senderName = ''): MailConfiguration
    {
        $this->senderName = $senderName;
    
        return $this;
    }

    /**
     * @return string
     */
    public function getSenderMail(): ?string
    {
        return $this->senderMail;
    }

    /**
     * @param string $senderMail
     *
     * @return MailConfiguration
     */
    public function setSenderMail(string $senderMail = ''): MailConfiguration
    {
        $this->senderMail = $senderMail;
    
        return $this;
    }

    /**
     * @return string
     */
    public function getReplyToMail(): ?string
    {
        return $this->replyToMail;
    }

    /**
     * @param string|null $replyToMail
     *
     * @return MailConfiguration
     */
    public function setReplyToMail(?string $replyToMail): MailConfiguration
    {
        $this->replyToMail = $replyToMail;
    
        return $this;
    }

    /**
     * @return int
     */
    public function getEncryption(): int
    {
        return $this->encryption;
    }

    /**
     * @param int $encryption
     *
     * @return MailConfiguration
     */
    public function setEncryption(int $encryption = self::ENCRYPTION_NONE): MailConfiguration
    {
        $this->encryption = $encryption;
    
        return $this;
    }

    /**
     * @return Collection|null|Channel[]
     */
    public function getChannels(): Collection
    {
        return $this->channels;
    }

    /**
     * @param Collection|null|Channel[] $channels
     *
     * @return MailConfiguration
     */
    public function setChannels(Collection $channels): self
    {
        $this->channels = $channels;

        return $this;
    }

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return MailConfiguration
     */
    public function setType(int $type = self::TYPE_DIRECT): self
    {
        $this->type = $type;
    
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getDkimDomain(): ?string
    {
        return $this->dkimDomain;
    }
    
    /**
     * @param null|string $dkimDomain
     *
     * @return MailConfiguration
     */
    public function setDkimDomain(?string $dkimDomain): self
    {
        $this->dkimDomain = $dkimDomain;
        
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getDkimSelector(): ?string
    {
        return $this->dkimSelector;
    }
    
    /**
     * @param null|string $dkimSelector
     *
     * @return MailConfiguration
     */
    public function setDkimSelector(?string $dkimSelector): self
    {
        $this->dkimSelector = $dkimSelector;
        
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getDkimKey(): ?string
    {
        return $this->dkimKey;
    }
    
    /**
     * @param null|string $dkimKey
     *
     * @return MailConfiguration
     */
    public function setDkimKey(?string $dkimKey): self
    {
        $this->dkimKey = $dkimKey;
        
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isDkimReady(): bool
    {
        return (!empty($this->getDkimKey()) && !empty($this->getDkimDomain()) && !empty($this->getDkimSelector()));
    }
}