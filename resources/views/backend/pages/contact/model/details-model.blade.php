<x-backend.model :id="'details-model'" class="lg:max-w-2xl" :button="false" :form_id="''" :action="''" :title="'Inquiry Details'"
    :method="''">
    @csrf
    <div class="details-content p-6 space-y-2">
        <h2 class="name"></h2>
        <h2 class="address"></h2>
        <h2 class="created_at"></h2>
        <h2 class="py-4">Subject: <span class="subject"></span></h2>
        <p class="description pb-4"></p>
        <h2 class="email"></h2>
        <h2 class="phone"></h2>
    </div>
</x-backend.model>

