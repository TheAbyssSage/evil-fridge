<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Evil Fridge Signals</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
        body {
            margin: 0;
            /* REMOVE overflow: hidden here */
            background-color: #080808;
            color: #f0f4ff;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        /* Make a scrollable page content wrapper */
        .page-wrapper {
            position: relative;
            min-height: 100vh;
            /* normal document flow -> scrolling works */
        }

        canvas {
            display: block;
        }

        /* Canvas only as a background band behind the header/main */
        .three-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            /* mouse goes through */
        }

        header,
        main,
        footer {
            position: relative;
            z-index: 10;
        }

        .lil-gui.autoPlace {
            position: fixed;
            bottom: 10px;
            right: 10px;
        }

        .card-bg {
            background-color: #020617;
            border-color: #1e293b;
        }

        .warning-box {
            background: #7f1d1d;
            border: 1px solid #fecaca;
        }
    </style>


    <!-- Import map so your ES module imports resolve to CDN versions -->
    <script type="importmap">
        {
            "imports": {
                "three": "https://unpkg.com/three@0.160.0/build/three.module.js",
                "three/addons/": "https://unpkg.com/three@0.160.0/examples/jsm/",
                "lil-gui": "https://unpkg.com/lil-gui@0.19.1/dist/lil-gui.esm.min.js"
            }
        }
    </script>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
</head>

<body>

    <header class="py-5 text-center text-white">
        <div class="container">
            <h1 class="display-5 fw-bold">Evil Fridge Containment Society</h1>
            <p class="lead mb-0">Because sometimes your leftovers stare back.</p>
        </div>
    </header>

    <main class="py-5">
        <div class="container">

            <!-- Conspiracy text -->
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8">
                    <div class="card card-bg shadow-lg border rounded-3 p-4">
                        <h2 class="h4 mb-3">The Fridge Conspiracy</h2>
                        <p>
                            For decades, we’ve trusted our fridges.
                            We’ve let them hum in the dark corners of our kitchens,
                            guarding pizza slices, cold brew, and that mysterious container from last month.
                        </p>
                        <p>
                            But what if your fridge isn’t just keeping things cold?
                            What if it’s feeding on your midnight snacks, draining your energy bill,
                            and whispering to the other appliances when you’re asleep?
                        </p>
                        <p>
                            Welcome to the <strong>Evil Fridge Containment Society</strong>.
                            Here, you can generate an official <em>Fridge Seal of Containment</em> —
                            a sacred PDF you can print and place on your fridge door to
                            seal away the malevolent spirit within.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card card-bg shadow-lg border rounded-3 p-4">
                        <h2 class="h4 mb-3">Generate your Fridge Seal PDF</h2>
                        <p>
                            Fill in the details below and we’ll create a personalized PDF “seal”
                            you can download and print. Tape it onto your fridge and sleep a little easier.
                        </p>

                        <form action="generate_pdf.php" method="post" class="mt-3">
                            <div class="mb-3">
                                <label for="keeper_name" class="form-label">
                                    Your Name (Fridge Keeper)
                                </label>
                                <input
                                    type="text"
                                    id="keeper_name"
                                    name="keeper_name"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="fridge_name" class="form-label">
                                    Fridge Name / Alias
                                </label>
                                <input
                                    type="text"
                                    id="fridge_name"
                                    name="fridge_name"
                                    class="form-control"
                                    placeholder="e.g. The Cold One, Frostbite, The Devourer"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">
                                    Fridge Location
                                </label>
                                <input
                                    type="text"
                                    id="location"
                                    name="location"
                                    class="form-control"
                                    placeholder="Kitchen, Dorm Room, Basement..."
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="incantation" class="form-label">
                                    Custom Incantation (optional but spooky)
                                </label>
                                <textarea
                                    id="incantation"
                                    name="incantation"
                                    class="form-control"
                                    rows="3"
                                    placeholder="By stale milk and frozen peas, I bind thee..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                Generate Seal PDF
                            </button>

                            <div class="mt-3 p-3 rounded warning-box text-light small">
                                This is obviously a parody and purely for fun.
                                No actual spirits, fridges, or leftovers will be harmed (probably).
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <footer class="py-4 text-center text-secondary small">
        &copy; <?php echo date('Y'); ?> Evil Fridge Containment Society &mdash; All snacks reserved.
    </footer>

    <!-- Bootstrap JS (optional, for components that need JS) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>

    <!-- Three.js + GUI animation -->
    <script type="module" src="js/evil-fridge-signals.js"></script>
</body>

</html>