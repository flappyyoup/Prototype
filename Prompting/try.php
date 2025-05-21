<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Interface</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-100 via-blue-200 to-blue-300 text-gray-800">
    <div id="app" class="max-w-6xl mx-auto p-6">
        <h1 class="text-4xl font-bold text-center text-blue-700 mb-8">User Profile</h1>
        
        <!-- Main Layout -->
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Profile Details Section -->
            <div class="bg-white shadow-lg rounded-[5%] p-6 flex-1">
                <div class="flex items-center mb-4">
                    <img id="profile-picture" src="https://via.placeholder.com/100" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover border-4 border-blue-500 mr-6">
                    <div>
                        <h2 class="text-3xl font-semibold text-gray-800 mb-2" id="fullname">John Doe</h2>
                        <p class="text-gray-600"><strong>Email:</strong> <span id="email">johndoe@example.com</span></p>
                        <p class="text-gray-600"><strong>Mobile Number:</strong> <span id="mobile">123-456-7890</span></p>
                        <p class="text-gray-600"><strong>Birthdate:</strong> <span id="birthdate">1990-01-01</span></p>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Form Section -->
            <div id="edit-profile-form" class="bg-white shadow-lg rounded-[5%] p-6 flex-1">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Profile</h2>
                <form id="profile-form" class="space-y-6">
                    <div>
                        <label for="profile-picture-input" class="block text-sm font-medium text-gray-700">Profile Picture:</label>
                        <input type="file" id="profile-picture-input" accept="image/*" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div>
                        <label for="fullname-input" class="block text-sm font-medium text-gray-700">Full Name:</label>
                        <input type="text" id="fullname-input" name="fullname" placeholder="Enter full name" class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="email-input" class="block text-sm font-medium text-gray-700">Email:</label>
                        <input type="email" id="email-input" name="email" placeholder="Enter email" class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="mobile-input" class="block text-sm font-medium text-gray-700">Mobile Number:</label>
                        <input type="tel" id="mobile-input" name="mobile" placeholder="Enter mobile number" class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="birthdate-input" class="block text-sm font-medium text-gray-700">Birthdate:</label>
                        <input type="date" id="birthdate-input" name="birthdate" class="mt-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white py-3 px-4 rounded-md hover:bg-blue-600 focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">Save</button>
                </form>
            </div>
        </div>

        <!-- Financial Transactions Section -->
        <div class="mt-8 bg-white shadow-lg rounded-[5%] p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Financial Overview</h2>
            
            <!-- Tabs for different financial sections -->
            <div class="border-b border-gray-200 mb-6">
                <nav class="flex space-x-8">
                    <button class="tab-button active px-1 py-4 text-blue-600 border-b-2 border-blue-600 font-medium" data-tab="transactions">Recent Transactions</button>
                    <button class="tab-button px-1 py-4 text-gray-500 hover:text-gray-700 font-medium" data-tab="loans">Active Loans</button>
                    <button class="tab-button px-1 py-4 text-gray-500 hover:text-gray-700 font-medium" data-tab="payments">Payment History</button>
                </nav>
            </div>

            <!-- Transactions Tab Content -->
            <div id="transactions" class="tab-content">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-03-15</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Monthly Salary</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">+$3,500.00</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">Completed</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-03-10</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rent Payment</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">-$1,200.00</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">Completed</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Loans Tab Content -->
            <div id="loans" class="tab-content hidden">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Home Loan</h3>
                                <p class="text-sm text-gray-500">Remaining Balance: $250,000</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Next Payment: $1,500</p>
                                <p class="text-sm text-gray-500">Due: 2024-04-01</p>
                            </div>
                        </div>
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 65%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments Tab Content -->
            <div id="payments" class="tab-content hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-03-01</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Loan Payment</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$1,500.00</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">Paid</td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-02-01</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Loan Payment</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">$1,500.00</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">Paid</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        const form = document.getElementById('profile-form');
        const profilePictureInput = document.getElementById('profile-picture-input');
        const profilePicture = document.getElementById('profile-picture');

        profilePictureInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (event) => {
                    profilePicture.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            document.getElementById('fullname').textContent = document.getElementById('fullname-input').value;
            document.getElementById('email').textContent = document.getElementById('email-input').value;
            document.getElementById('mobile').textContent = document.getElementById('mobile-input').value;
            document.getElementById('birthdate').textContent = document.getElementById('birthdate-input').value;
        });

        // Tab switching functionality
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
                    btn.classList.add('text-gray-500');
                });

                // Add active class to clicked button
                button.classList.add('active', 'text-blue-600', 'border-blue-600');
                button.classList.remove('text-gray-500');

                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Show selected tab content
                const tabId = button.getAttribute('data-tab');
                document.getElementById(tabId).classList.remove('hidden');
            });
        });
    </script>
</body>
</html>