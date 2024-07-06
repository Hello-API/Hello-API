<?php

namespace App\Containers\AppSection\Authentication\UI\API\Documentation\Schemas;

use App\Containers\AppSection\Authentication\UI\API\Documentation\Schemas\Properties\EmailPropertySchema;
use App\Containers\AppSection\Authentication\UI\API\Requests\RegisterUserRequest;
use App\Ship\Documentation\API\RuleExtractor;
use App\Ship\Documentation\Collections\PrivateCollection;
use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use MohammadAlavi\LaravelOpenApi\Attributes\Collection;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\SchemaFactory;

#[Collection([PrivateCollection::class])]
class RegisterUserSchema extends SchemaFactory implements Reusable
{
    /**
     * @throws InvalidArgumentException
     */
    public function build(): SchemaContract
    {
        return Schema::object(class_basename($this))
            ->properties(
                EmailPropertySchema::ref('email'),
                Schema::string('password')
                    ->format(Schema::FORMAT_PASSWORD)
                    ->description('min:10|max:64|at least one uppercase and one lowercase letter|at least one number|at least one symbol')
                    ->example('p@a$sw0orDd'),
                Schema::string('name')
                    ->description(RuleExtractor::getRuleFrom(RegisterUserRequest::injectData(), 'name'))
                    ->example('John Doe'),
                Schema::string('verification_url')->nullable()
                    ->enum(...config('appSection-authentication.allowed-verify-email-urls')),
                Schema::string('campaign')->nullable(),
                Schema::string('recaptcha_token')
                    ->default(env('GOOGLE_CAPTCHA_BYPASS_KEY'))
            )->required('email', 'password', 'recaptcha_token');
    }
}
