<x-Deshboard-layout>

    <!-- =============================SMTP configuration=============================================== -->
    <form action="{{ route('write_env') }}" method="POST" class="2xl:container 2xl:mx-auto md:mx-section">
        @csrf
        <section>
            <!-- Business setting -->
            <section id="business-setting">
                <div class="grid grid-cols-12 space-y-4 px-[18px]">
                    <!-- Company Information -->
                    <section
                        class="col-span-12 py-5 rounded-md border transition-shadow duration-500 bg-skin-backend-content">

                        <div class="grid grid-cols-12 gap-4 px-4 py-2">
                            <div class="col-span-12 md:col-span-6">
                                <input type="hidden" name="types[]" value="MAIL_MAILER">
                                <label for="company-name"
                                    class="text-sm text-skin-backend-heading">{{ translation('MAIL MAILER') }}</label>
                                <select class="ddss-select-without-search w-full" name="MAIL_MAILER"
                                    value="{{ old('status') }}">
                                    <option value="smtp" @selected(env('MAIL_MAILER') == 'smtp')>{{ translation('SMTP') }}</option>
                                    <option value="sendmail" @selected(env('MAIL_MAILER') == 'sendmail')>{{ translation('Send Mail') }}</option>
                                    <i class="bx bx-chevron-down absolute top-0 right-0"></i>
                                </select>
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label for="company-name"
                                    class="text-sm text-skin-backend-heading">{{ translation('MAIL HOST') }}</label>
                                <input type="hidden" name="types[]" value="MAIL_HOST">
                                <input type="text" placeholder="MAIL HOST" name="MAIL_HOST"
                                    value="{{ env('MAIL_HOST') }}" required
                                    class="w-full rounded-md bg-skin-backend-highlight border-gray-200 focus:border-gray-300 focus:ring-0">
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label for="company-name"
                                    class="text-sm text-skin-backend-heading">{{ translation('MAIL PORT') }}</label>
                                <input type="hidden" name="types[]" value="MAIL_PORT">
                                <input type="text" placeholder="MAIL PORT" name="MAIL_PORT"
                                    value="{{ env('MAIL_PORT') }}" required
                                    class="w-full rounded-md bg-skin-backend-highlight border-gray-200 focus:border-gray-300 focus:ring-0">
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label for="company-name"
                                    class="text-sm text-skin-backend-heading">{{ translation('MAIL USERNAME') }}</label>
                                <input type="hidden" name="types[]" value="MAIL_USERNAME">
                                <input type="text" placeholder="MAIL USERNAME" name="MAIL_USERNAME"
                                    value="{{ env('MAIL_USERNAME') }}" required
                                    class="w-full rounded-md bg-skin-backend-highlight border-gray-200 focus:border-gray-300 focus:ring-0">
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label for="company-name"
                                    class="text-sm text-skin-backend-heading">{{ translation('MAIL PASSWORD') }}</label>
                                <input type="hidden" name="types[]" value="MAIL_PASSWORD">
                                <input type="text" placeholder="MAIL PASSWORD" name="MAIL_PASSWORD"
                                    value="{{ env('MAIL_PASSWORD') }}" required
                                    class="w-full rounded-md bg-skin-backend-highlight border-gray-200 focus:border-gray-300 focus:ring-0">
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label for="company-name"
                                    class="text-sm text-skin-backend-heading">{{ translation('MAIL ENCRYPTION') }}</label>
                                <input type="hidden" name="types[]" value="MAIL_ENCRYPTION">
                                <input type="text" placeholder="MAIL ENCRYPTION" name="MAIL_ENCRYPTION"
                                    value="{{ env('MAIL_ENCRYPTION') }}" required
                                    class="w-full rounded-md bg-skin-backend-highlight border-gray-200 focus:border-gray-300 focus:ring-0">
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label for="company-name"
                                    class="text-sm text-skin-backend-heading">{{ translation('MAIL FROM ADDRESS') }}</label>
                                <input type="hidden" name="types[]" value="MAIL_FROM_ADDRESS">
                                <input type="text" placeholder="MAIL FROM ADDRESS" name="MAIL_FROM_ADDRESS"
                                    value="{{ env('MAIL_FROM_ADDRESS') }}" required
                                    class="w-full rounded-md bg-skin-backend-highlight border-gray-200 focus:border-gray-300 focus:ring-0">
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <label for="company-name"
                                    class="text-sm text-skin-backend-heading">{{ translation('MAIL FROM NAME') }}</label>
                                <input type="hidden" name="types[]" value="MAIL_FROM_NAME">
                                <input type="text" placeholder="MAIL FROM NAME" name="MAIL_FROM_NAME"
                                    value="{{ env('MAIL_FROM_NAME') }}" required
                                    class="w-full rounded-md bg-skin-backend-highlight border-gray-200 focus:border-gray-300 focus:ring-0">
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </section>
        <div class="w-full flex justify-end my-4">
            <button
                class="px-4 py-2 bg-skin-backend-button  font-medium rounded-md text-sm hover:bg-skin-backend-button-hover transition-colors">{{ translation("Save
                                Information") }}</button>
        </div>
    </form>

</x-Deshboard-layout>
    