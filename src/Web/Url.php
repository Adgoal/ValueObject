<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Web;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use Exception;
use function parse_url;

/**
 * Class Url.
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Url implements ValueObjectInterface
{
    /**
     * SchemeName ValueObject.
     *
     * @var SchemeName
     */
    protected $scheme;

    /**
     * User StringLiteral ValueObject.
     *
     * @var StringLiteral
     */
    protected $user;

    /**
     * Pass StringLiteral ValueObject.
     *
     * @var StringLiteral
     */
    protected $password;

    /**
     * Domain ValueObject.
     *
     * @var Domain
     */
    protected $domain;

    /**
     * Path ValueObject.
     *
     * @var Path
     */
    protected $path;

    /**
     * PortNumberInterface ValueObject.
     *
     * @var PortNumberInterface
     */
    protected $port;

    /**
     * QueryString ValueObject.
     *
     * @var QueryStringInterface
     */
    protected $queryString;

    /**
     * FragmentIdentifier ValueObject.
     *
     * @var FragmentIdentifierInterface
     */
    protected $fragmentIdentifier;

    /**
     * Returns a new Url object from a native url string.
     *
     * @return Url
     */
    public static function fromNative(): ValueObjectInterface
    {
        $urlString = func_get_arg(0);

        $user = parse_url($urlString, PHP_URL_USER);
        $pass = parse_url($urlString, PHP_URL_PASS);
        $host = parse_url($urlString, PHP_URL_HOST);
        $queryString = parse_url($urlString, PHP_URL_QUERY);
        $fragmentId = parse_url($urlString, PHP_URL_FRAGMENT);
        $port = parse_url($urlString, PHP_URL_PORT);
        $path = parse_url($urlString, PHP_URL_PATH);

        $scheme = new SchemeName(parse_url($urlString, PHP_URL_SCHEME));
        $user = $user ? new StringLiteral($user) : new StringLiteral('');
        $pass = $pass ? new StringLiteral($pass) : new StringLiteral('');
        $domain = Domain::specifyType($host);
        $path = new Path($path ?? '');
        $portNumber = $port ? new PortNumber($port) : new NullPortNumber();
        $query = $queryString ? new QueryString(sprintf('?%s', $queryString)) : new NullQueryString();
        $fragment = $fragmentId ? new FragmentIdentifier(sprintf('#%s', $fragmentId)) : new NullFragmentIdentifier();

        return new self($scheme, $user, $pass, $domain, $portNumber, $path, $query, $fragment);
    }

    /**
     * Returns a new Url object.
     *
     * @param SchemeName                  $scheme
     * @param StringLiteral               $user
     * @param StringLiteral               $password
     * @param Domain                      $domain
     * @param PortNumberInterface         $port
     * @param Path                        $path
     * @param QueryStringInterface        $query
     * @param FragmentIdentifierInterface $fragment
     */
    public function __construct(
        SchemeName $scheme,
        StringLiteral $user,
        StringLiteral $password,
        Domain $domain,
        PortNumberInterface $port,
        Path $path,
        QueryStringInterface $query,
        FragmentIdentifierInterface $fragment
    ) {
        $this->scheme = $scheme;
        $this->user = $user;
        $this->password = $password;
        $this->domain = $domain;
        $this->path = $path;
        $this->port = $port;
        $this->queryString = $query;
        $this->fragmentIdentifier = $fragment;
    }

    /**
     * Tells whether two Url are sameValueAs by comparing their components.
     *
     * @param ValueObjectInterface $url
     *
     * @return bool
     *
     * @throws Exception
     *
     * @psalm-suppress UndefinedInterfaceMethod
     */
    public function sameValueAs(ValueObjectInterface $url): bool
    {
        if (!$url instanceof static) {
            return false;
        }

        return $this->getScheme()->sameValueAs($url->getScheme()) &&
               $this->getUser()->sameValueAs($url->getUser()) &&
               $this->getPassword()->sameValueAs($url->getPassword()) &&
               $this->getDomain()->sameValueAs($url->getDomain()) &&
               $this->getPath()->sameValueAs($url->getPath()) &&
               $this->getPort()->sameValueAs($url->getPort()) &&
               $this->getQueryString()->sameValueAs($url->getQueryString()) &&
               $this->getFragmentIdentifier()->sameValueAs($url->getFragmentIdentifier())
        ;
    }

    /**
     * Returns the domain of the Url.
     *
     * @return Domain
     */
    public function getDomain(): Domain
    {
        return clone $this->domain;
    }

    /**
     * Returns the fragment identifier of the Url.
     *
     * @return FragmentIdentifierInterface
     */
    public function getFragmentIdentifier(): FragmentIdentifierInterface
    {
        return clone $this->fragmentIdentifier;
    }

    /**
     * Returns the password part of the Url.
     *
     * @return StringLiteral
     */
    public function getPassword(): StringLiteral
    {
        return clone $this->password;
    }

    /**
     * Returns the path of the Url.
     *
     * @return Path
     */
    public function getPath(): StringLiteral
    {
        return clone $this->path;
    }

    /**
     * Returns the port of the Url.
     *
     * @return PortNumberInterface
     */
    public function getPort(): PortNumberInterface
    {
        return clone $this->port;
    }

    /**
     * Returns the query string of the Url.
     *
     * @return QueryStringInterface
     */
    public function getQueryString(): QueryStringInterface
    {
        return clone $this->queryString;
    }

    /**
     * Returns the scheme of the Url.
     *
     * @return SchemeName
     */
    public function getScheme(): SchemeName
    {
        return clone $this->scheme;
    }

    /**
     * Returns the user part of the Url.
     *
     * @return StringLiteral
     */
    public function getUser(): StringLiteral
    {
        return clone $this->user;
    }

    /**
     * Return native value.
     *
     * @return string
     */
    public function toNative()
    {
        return $this->__toString();
    }

    /**
     * Returns a string representation of the url.
     *
     * @return string
     */
    public function __toString(): string
    {
        $userPass = '';

        if (false === $this->getUser()->isEmpty()) {
            $userPass = sprintf('%s@', (string) $this->getUser());

            if (false === $this->getPassword()->isEmpty()) {
                $userPass = sprintf('%s:%s@', (string) $this->getUser(), (string) $this->getPassword());
            }
        }

        $port = '';

        if (false === NullPortNumber::create()->sameValueAs($this->getPort())) {
            $port = sprintf(':%d', $this->getPort()->toNative());
        }

        return sprintf('%s://%s%s%s%s%s%s',
            $this->getScheme()->__toString(),
            $userPass,
            $this->getDomain()->__toString(),
            $port,
            $this->getPath()->__toString(),
            $this->getQueryString()->__toString(),
            $this->getFragmentIdentifier()->__toString()
        );
    }
}
