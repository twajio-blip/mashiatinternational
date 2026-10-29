{{-- resources/views/frontend/services/student-visa-financial-assessment.blade.php --}}

@extends('layouts.app')

@section('content')

<main id="main">

    {{-- Hero --}}
    <section>
        <div>
            <a href="#">
                Student Visa Financial Documentation
            </a>

            <h1>Student Visa Financial Assessment</h1>

            <p>
                Our student visa financial assessment service helps students
                understand and prepare the financial documentation required
                for their visa application.
            </p>

            <div>
                <a href="#consultation">
                    Book Consultation
                </a>

                <a href="tel:+880000000000">
                    Call us
                </a>
            </div>
        </div>
    </section>


    {{-- Services Directory --}}
    <section>
        <div>

            <aside>
                <details>
                    <summary>Services</summary>

                    <nav>
                        <a href="#">Student Visa Financial Documentation</a>
                        <a href="#">Student Visa Application</a>
                        <a href="#">University Admission</a>
                        <a href="#">Scholarship Guidance</a>
                        <a href="#">Migration Consultation</a>
                    </nav>
                </details>

                <nav>
                    <a href="#">Student Visa Financial Documentation</a>
                    <a href="#">Student Visa Application</a>
                    <a href="#">University Admission</a>
                    <a href="#">Scholarship Guidance</a>
                    <a href="#">Migration Consultation</a>
                </nav>
            </aside>


            <div>

                {{-- Service Overview --}}
                <section>
                    <h2>Service overview</h2>

                    <p>
                        Student visa financial assessment provides a detailed
                        review of your financial circumstances and supporting
                        documents before you submit your visa application.
                    </p>
                </section>


                {{-- What We Assist With --}}
                <section>
                    <h2>What Mashiat International assists with</h2>

                    <ul>
                        <li>Reviewing your financial position</li>
                        <li>Assessing available funds</li>
                        <li>Reviewing bank statements</li>
                        <li>Checking supporting financial documents</li>
                        <li>Identifying potential documentation gaps</li>
                        <li>Preparing you for financial questions</li>
                    </ul>
                </section>


                {{-- Required Documents --}}
                <section>
                    <h2>Information and documents required</h2>

                    <ul>
                        <li>Valid passport</li>
                        <li>Bank statements</li>
                        <li>Bank certificates</li>
                        <li>Income documents</li>
                        <li>Sponsor information</li>
                        <li>Employment documents where applicable</li>
                        <li>Property or asset documentation where applicable</li>
                    </ul>
                </section>


                {{-- Timeline --}}
                <section>
                    <h2>How the engagement runs</h2>

                    <ol>
                        <li>
                            <h3>Initial consultation</h3>
                            <p>
                                We discuss your circumstances and intended
                                destination.
                            </p>
                        </li>

                        <li>
                            <h3>Document review</h3>
                            <p>
                                Your available financial documentation is
                                reviewed.
                            </p>
                        </li>

                        <li>
                            <h3>Financial assessment</h3>
                            <p>
                                We assess the information against the relevant
                                requirements.
                            </p>
                        </li>

                        <li>
                            <h3>Recommendations</h3>
                            <p>
                                We identify missing or potentially problematic
                                documentation.
                            </p>
                        </li>

                        <li>
                            <h3>Final preparation</h3>
                            <p>
                                You receive guidance for preparing your final
                                financial documentation.
                            </p>
                        </li>
                    </ol>
                </section>


                {{-- FAQ --}}
                <section>
                    <h2>Frequently asked questions</h2>

                    <details open>
                        <summary>
                            What is a student visa financial assessment?
                        </summary>

                        <p>
                            It is a review of your financial circumstances and
                            supporting documents to help you prepare for the
                            financial requirements of your student visa.
                        </p>
                    </details>

                    <details>
                        <summary>
                            Why do I need a financial assessment?
                        </summary>

                        <p>
                            A financial assessment can help identify missing
                            information or documentation before your visa
                            application is submitted.
                        </p>
                    </details>

                    <details>
                        <summary>
                            Can you review my bank statements?
                        </summary>

                        <p>
                            Yes. Bank statements can be reviewed as part of the
                            financial documentation assessment.
                        </p>
                    </details>
                </section>


                {{-- Consultants --}}
                <section>
                    <h2>Consultants for this service</h2>

                    <div>

                        <article>
                            <img
                                src="{{ asset('images/kamrul-hasan.jpg') }}"
                                alt="Kamrul Hasan"
                            >

                            <h3>Kamrul Hasan</h3>

                            <p>Student Visa Consultant</p>
                        </article>

                        <article>
                            <img
                                src="{{ asset('images/nusrat-jahan.jpg') }}"
                                alt="Nusrat Jahan"
                            >

                            <h3>Nusrat Jahan</h3>

                            <p>Student Visa Consultant</p>
                        </article>

                    </div>
                </section>


                {{-- Dark CTA --}}
                <section>
                    <h2>
                        Discuss student visa financial assessment
                        with a consultant
                    </h2>

                    <p>
                        Speak with our consultants about your financial
                        documentation and student visa requirements.
                    </p>

                    <a href="https://wa.me/880000000000">
                        WhatsApp us
                    </a>
                </section>

            </div>
        </div>
    </section>


    {{-- Consultation --}}
    <section id="consultation">

        <div>

            <div>
                <h2>Book a consultation</h2>

                <p>
                    Get guidance from our consultants about your student visa
                    financial assessment.
                </p>

                <ul>
                    <li>Personalised consultation</li>
                    <li>Financial document review</li>
                    <li>Clear recommendations</li>
                    <li>Application preparation guidance</li>
                </ul>
            </div>


            <div>

                <form action="#" method="POST">

                    @csrf

                    <div>
                        <label for="full_name">Full name</label>

                        <input
                            type="text"
                            id="full_name"
                            name="full_name"
                            placeholder="Your full name"
                        >
                    </div>


                    <div>
                        <label for="phone">
                            Phone / WhatsApp
                        </label>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="Your phone number"
                        >
                    </div>


                    <div>
                        <label for="email">Email</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Your email address"
                        >
                    </div>


                    <div>
                        <label for="destination">
                            Destination
                        </label>

                        <select id="destination" name="destination">
                            <option value="">Select destination</option>
                            <option value="Australia">Australia</option>
                            <option value="Canada">Canada</option>
                            <option value="UK">United Kingdom</option>
                            <option value="USA">USA</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>


                    <div>
                        <label for="intake">Intake</label>

                        <select id="intake" name="intake">
                            <option value="">Select intake</option>
                            <option value="January">January</option>
                            <option value="May">May</option>
                            <option value="September">September</option>
                        </select>
                    </div>


                    <div>
                        <label for="service">Service</label>

                        <input
                            type="text"
                            id="service"
                            name="service"
                            value="Student Visa Financial Assessment"
                            readonly
                        >
                    </div>


                    <div>
                        <label for="message">Message</label>

                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            placeholder="Tell us about your requirements"
                        ></textarea>
                    </div>


                    <p>
                        By submitting this form, you agree to our privacy
                        policy.
                    </p>


                    <button type="submit">
                        Submit Consultation Request
                    </button>

                </form>

            </div>

        </div>

    </section>

</main>

@endsection