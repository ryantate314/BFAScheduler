class CreateHoursUpdates < ActiveRecord::Migration
  def change
    create_table :hours_updates do |t|
      t.Date :date
      t.int :hours
      t.int :id

      t.timestamps null: false
    end
  end
end
