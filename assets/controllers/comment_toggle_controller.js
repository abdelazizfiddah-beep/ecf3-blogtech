import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        url: String,
        approved: String,
    };

    connect() {
        this.element.addEventListener('click', this.toggle.bind(this));
        this.element.textContent = this.approvedValue === '1' ? 'Unapprove' : 'Approve';
    }

    async toggle(event) {
        event.preventDefault();

        const response = await fetch(this.urlValue, {
            method: 'PATCH',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error(`Erreur ${response.status}`);
        }

        const data = await response.json();

        this.approvedValue = data.approved ? '1' : '0';
        this.element.textContent = data.approved ? 'Unapprove' : 'Approve';

        const approvedCell = this.element.closest('tr').querySelector('td:nth-child(4)');
        if (approvedCell) {
            approvedCell.textContent = data.approved ? 'Yes' : 'No';
        }
    }
}