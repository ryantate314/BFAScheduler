class CreateWorkers < ActiveRecord::Migration
  def change
    create_table :workers do |t|
      t.string :firstName
      t.string :lastName
      t.string :email
      t.string :phone

      t.timestamps null: false
    end
  end
end
