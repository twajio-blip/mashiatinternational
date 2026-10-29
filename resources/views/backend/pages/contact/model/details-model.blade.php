<x-backend.model :id="'details-model'" class="lg:max-w-2xl" :button="false" :form_id="''" :action="''" :title="'Inquiry Details'"
    :method="''">
    @csrf
    <div class="details-content p-6 space-y-2">
        <h2>Name: <span class="name"></span></h2>
        <h2>Phone / WhatsApp: <span class="phone"></span></h2>
        <h2>Email: <span class="email"></span></h2>
        <h2>Preferred destination: <span class="destination"></span></h2>
        <h2>Intended intake: <span class="intake"></span></h2>
        <h2>Service required: <span class="service"></span></h2>
        <h2>Submitted at: <span class="created_at"></span></h2>
        <div class="py-4">
            <h2 class="font-semibold">Message</h2>
            <p class="message pt-2"></p>
        </div>
    </div>
</x-backend.model>

