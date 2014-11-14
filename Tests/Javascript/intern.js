// Learn more about configuring this file at <https://github.com/theintern/intern/wiki/Configuring-Intern>.
// These default settings work OK for most people. The options that *must* be changed below are the
// packages, suites, excludeInstrumentation, and (if you want functional tests) functionalSuites.
define({
    // The port on which the instrumenting proxy will listen

    environments: [
        { browserName: 'phantomjs' }
    ],

    // Maximum number of simultaneous integration tests that should be executed on the remote WebDriver service
    maxConcurrency: 3,

    // Name of the tunnel class to use for WebDriver tests
    tunnel: 'SauceLabsTunnel',

    // The desired AMD loader to use when running unit tests (client.html/client.js). Omit to use the default Dojo
    // loader
    useLoader: {
        'host-node': 'dojo/dojo',
        'host-browser': 'node_modules/dojo/dojo.js'
    },

    // Configuration options for the module loader; any AMD configuration options supported by the specified AMD loader
    // can be used here
    loader: {
        // Packages that should be registered with the loader in each testing environment
        packages: [ { name: 'myPackage', location: '.' } ]
    },

    // Non-functional test suite(s) to run in each browser
    suites: [ /* 'myPackage/tests/foo', 'myPackage/tests/bar' */ ],

    // Functional test suite(s) to run in each browser once non-functional tests are completed
    functionalSuites: [ /* 'myPackage/tests/functional' */ ],

    // A regular expression matching URLs to files that should not be included in code coverage analysis
    excludeInstrumentation: /^(?:tests|node_modules)\//
});
