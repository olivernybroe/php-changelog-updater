<?php

declare(strict_types=1);

it('places given release notes in correct position in given markdown changelog', function () {
    $this->artisan('update', [
        '--release-notes' => <<<MD
        ### Added
        - New Feature A
        - New Feature B

        ### Changed
        - Update Feature C

        ### Removes
        - Remove Feature D
        MD,
        '--latest-version' => 'v1.0.0',
        '--path-to-changelog' => __DIR__ . '/../Stubs/base-changelog.md',
        '--release-date' => '2021-02-01',
    ])
         ->expectsOutput(file_get_contents(__DIR__ . '/../Stubs/expected-changelog.md'))
         ->assertExitCode(0);
});

it('throws error if release-notes are missing', function () {
    $this->markTestIncomplete('TODO: Add Validation to Update Command');

    $this->artisan('update')
       ->assertExitCode(1);
});

it('uses current date for release date if no option is provieded', function () {
    $expectedChangelog = file_get_contents(__DIR__ . '/../Stubs/expected-changelog.md');
    $expectedOutput = str_replace('2021-02-01', now()->format('Y-m-d'), $expectedChangelog);

    $this->artisan('update', [
        '--release-notes' => <<<MD
        ### Added
        - New Feature A
        - New Feature B

        ### Changed
        - Update Feature C

        ### Removes
        - Remove Feature D
        MD,
        '--latest-version' => 'v1.0.0',
        '--path-to-changelog' => __DIR__ . '/../Stubs/base-changelog.md',
    ])
         ->expectsOutput($expectedOutput)
         ->assertExitCode(0);
});

it('uses current date for release date if option is empty', function () {
    $expectedChangelog = file_get_contents(__DIR__ . '/../Stubs/expected-changelog.md');
    $expectedOutput = str_replace('2021-02-01', now()->format('Y-m-d'), $expectedChangelog);

    $this->artisan('update', [
        '--release-notes' => <<<MD
        ### Added
        - New Feature A
        - New Feature B

        ### Changed
        - Update Feature C

        ### Removes
        - Remove Feature D
        MD,
        '--latest-version' => 'v1.0.0',
        '--path-to-changelog' => __DIR__ . '/../Stubs/base-changelog.md',
        '--release-date' => '',
    ])
         ->expectsOutput($expectedOutput)
         ->assertExitCode(0);
});

it('places given release notes in correct position in given markdown changelog when no unreleased heading is available', function () {
    $this->artisan('update', [
        '--release-notes' => <<<MD
        ### Added
        - New Feature A
        - New Feature B

        ### Changed
        - Update Feature C

        ### Removes
        - Remove Feature D
        MD,
        '--latest-version' => 'v1.0.0',
        '--path-to-changelog' => __DIR__ . '/../Stubs/base-changelog-without-unreleased.md',
        '--release-date' => '2021-02-01',
    ])
         ->expectsOutput(file_get_contents(__DIR__ . '/../Stubs/expected-changelog-without-unreleased.md'))
         ->assertExitCode(0);
});

it('places given release notes in correct position in given markdown changelog when no heading is available', function () {
    $this->artisan('update', [
        '--release-notes' => <<<MD
        ### Added
        - New Feature A
        - New Feature B

        ### Changed
        - Update Feature C

        ### Removes
        - Remove Feature D
        MD,
        '--latest-version' => 'v1.0.0',
        '--path-to-changelog' => __DIR__ . '/../Stubs/base-changelog-without-headings.md',
        '--release-date' => '2021-02-01',
    ])
         ->expectsOutput(file_get_contents(__DIR__ . '/../Stubs/expected-changelog-without-headings.md'))
         ->assertExitCode(0);
});
