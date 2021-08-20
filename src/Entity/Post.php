<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Post
{

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime('now'));
        $this->userVotes = new ArrayCollection();
    }

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, options={"default": ""})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=UserVote::class, mappedBy="post")
     */
    private $userVotes;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
    */
    public function updatedTimestamps(): void
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
    }

    public function getPostAge(): string
    {
        $diff = $this->getCreatedAt()->diff(new \DateTime());

        if($diff->y) {
            $value = $diff->y;
            $suffix = ' year(s)';
        } elseif($diff->m) {
            $value = $diff->m;
            $suffix = ' month(s)';
        } elseif($diff->d) {
            $value = $diff->d;
            $suffix = ' day(s)';
        } elseif($diff->h) {
            $value = $diff->h;
            $suffix = ' hour(s)';
        } elseif($diff->i) {
            $value = $diff->i;
            $suffix = ' min';
        } elseif($diff->s) {
            $value = $diff->s;
            $suffix = ' sec';
        } else {
            $value = 1;
            $suffix = ' sec';
        }

        return strval($value) . $suffix;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getSourceUrl($url): string
    {
        if (!is_null($url)) {
            preg_match('@^(http[s]?:\/\/)?([^\/\s]+)(.*)@i', $this->getUrl(), $matches);
            return $matches[2];
        } else {
            return "";
        }
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getVotes(): ?int
    {
        $userVotes = $this->getUserVotes();
        $totalVotes = 0;

        foreach ($userVotes as $userVote) {
            $totalVotes += $userVote->getValue();
        }
        
        return $totalVotes;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|UserVote[]
     */
    public function getUserVotes(): Collection
    {
        return $this->userVotes;
    }

    public function addUserVote(UserVote $userVote): self
    {
        if (!$this->userVotes->contains($userVote)) {
            $this->userVotes[] = $userVote;
            $userVote->setPost($this);
        }

        return $this;
    }

    public function removeUserVote(UserVote $userVote): self
    {
        if ($this->userVotes->removeElement($userVote)) {
            // set the owning side to null (unless already changed)
            if ($userVote->getPost() === $this) {
                $userVote->setPost(null);
            }
        }

        return $this;
    }
}
