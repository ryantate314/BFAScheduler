class CreateWorkers < ActiveRecord::Migration
  def change
    create_table :workers do |t|
	t.belongs_to :EventWorkerPosition
      t.int :id
      t.string :name
      t.string :emailAddress
      t.string :phoneNumber

      t.timestamps null: false
    end
  end
end
