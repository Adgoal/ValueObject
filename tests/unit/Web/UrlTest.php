<?php

declare(strict_types=1);

namespace AdgoalCommon\ValueObject\Tests\Unit\Web;

use AdgoalCommon\ValueObject\StringLiteral\StringLiteral;
use AdgoalCommon\ValueObject\Tests\Unit\TestCase;
use AdgoalCommon\ValueObject\ValueObjectInterface;
use AdgoalCommon\ValueObject\Web\FragmentIdentifier;
use AdgoalCommon\ValueObject\Web\Hostname;
use AdgoalCommon\ValueObject\Web\NullPortNumber;
use AdgoalCommon\ValueObject\Web\Path;
use AdgoalCommon\ValueObject\Web\PortNumber;
use AdgoalCommon\ValueObject\Web\QueryString;
use AdgoalCommon\ValueObject\Web\SchemeName;
use AdgoalCommon\ValueObject\Web\Url;

class UrlTest extends TestCase
{
    /** @var Url */
    protected $url;

    protected function setUp(): void
    {
        $this->url = new Url(
            new SchemeName('http'),
            new StringLiteral('user'),
            new StringLiteral('pass'),
            new Hostname('foo.com'),
            new PortNumber(80),
            new Path('/bar'),
            new QueryString('?querystring'),
            new FragmentIdentifier('#fragmentidentifier')
        );
    }

    public function testFromNative(): void
    {
        $nativeUrlString = 'http://user:pass@foo.com:80/bar?querystring#fragmentidentifier';
        $fromNativeUrl = Url::fromNative($nativeUrlString);

        $this->assertTrue($this->url->sameValueAs($fromNativeUrl));

        $nativeUrlString = 'http://www.test.com';
        $fromNativeUrl = Url::fromNative($nativeUrlString);

        $this->assertSame($nativeUrlString, $fromNativeUrl->__toString());

        $nativeUrlString = 'http://www.test.com/bar';
        $fromNativeUrl = Url::fromNative($nativeUrlString);

        $this->assertSame($nativeUrlString, $fromNativeUrl->__toString());

        $nativeUrlString = 'http://www.test.com/?querystring';
        $fromNativeUrl = Url::fromNative($nativeUrlString);

        $this->assertSame($nativeUrlString, $fromNativeUrl->__toString());

        $nativeUrlString = 'http://www.test.com/#fragmentidentifier';
        $fromNativeUrl = Url::fromNative($nativeUrlString);

        $this->assertSame($nativeUrlString, $fromNativeUrl->__toString());
    }

    public function testSameValueAs(): void
    {
        $url2 = new Url(
            new SchemeName('http'),
            new StringLiteral('user'),
            new StringLiteral('pass'),
            new Hostname('foo.com'),
            new PortNumber(80),
            new Path('/bar'),
            new QueryString('?querystring'),
            new FragmentIdentifier('#fragmentidentifier')
        );

        $this->assertTrue($this->url->sameValueAs($url2));
        $this->assertTrue($url2->sameValueAs($this->url));

        $mock = $this->getMockBuilder(ValueObjectInterface::class)->getMock();
        $this->assertFalse($this->url->sameValueAs($mock));
    }

    public function testGetDomain(): void
    {
        $domain = new Hostname('foo.com');
        $this->assertTrue($this->url->getDomain()->sameValueAs($domain));
    }

    public function testGetFragmentIdentifier(): void
    {
        $fragment = new FragmentIdentifier('#fragmentidentifier');
        $this->assertTrue($this->url->getFragmentIdentifier()->sameValueAs($fragment));
    }

    public function testGetPassword(): void
    {
        $password = new StringLiteral('pass');
        $this->assertTrue($this->url->getPassword()->sameValueAs($password));
    }

    public function testGetPath(): void
    {
        $path = new Path('/bar');
        $this->assertTrue($this->url->getPath()->sameValueAs($path));
    }

    public function testGetPort(): void
    {
        $port = new PortNumber(80);
        $this->assertTrue($this->url->getPort()->sameValueAs($port));
    }

    public function testGetQueryString(): void
    {
        $queryString = new QueryString('?querystring');
        $this->assertTrue($this->url->getQueryString()->sameValueAs($queryString));
    }

    public function testGetScheme(): void
    {
        $scheme = new SchemeName('http');
        $this->assertTrue($this->url->getScheme()->sameValueAs($scheme));
    }

    public function testGetUser(): void
    {
        $user = new StringLiteral('user');
        $this->assertTrue($this->url->getUser()->sameValueAs($user));
    }

    public function testToString(): void
    {
        $this->assertSame('http://user:pass@foo.com:80/bar?querystring#fragmentidentifier', $this->url->__toString());
    }

    public function testAuthlessUrlToString(): void
    {
        $nativeUrlString = 'http://foo.com:80/bar?querystring#fragmentidentifier';
        $authlessUrl = new Url(
            new SchemeName('http'),
            new StringLiteral(''),
            new StringLiteral(''),
            new Hostname('foo.com'),
            new PortNumber(80),
            new Path('/bar'),
            new QueryString('?querystring'),
            new FragmentIdentifier('#fragmentidentifier')
        );
        $this->assertSame($nativeUrlString, (string) $authlessUrl);

        Url::fromNative($nativeUrlString);
        $this->assertSame($nativeUrlString, (string) Url::fromNative((string) $authlessUrl));
    }

    public function testNullPortUrlToString(): void
    {
        $nullPortUrl = new Url(
            new SchemeName('http'),
            new StringLiteral('user'),
            new StringLiteral(''),
            new Hostname('foo.com'),
            new NullPortNumber(),
            new Path('/bar'),
            new QueryString('?querystring'),
            new FragmentIdentifier('#fragmentidentifier')
        );
        $this->assertSame('http://user@foo.com/bar?querystring#fragmentidentifier', $nullPortUrl->__toString());
    }
}
